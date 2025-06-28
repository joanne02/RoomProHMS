<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ApplicationSession;
use App\Models\User;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Semester;
use App\Models\AllocationStatus;
use App\Notifications\ApplicationStatusUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Silber\Bouncer\BouncerFacade as Bouncer;

class ApplicationController extends Controller
{
    public function indexApplication()
    {
        $user = auth()->user();

        if ($user->usertype === 'superadmin' || $user->usertype === 'staff') {
            $session_lists = ApplicationSession::all();
            return view('application_session.main_application_session', compact('session_lists'));
        }

        // For users/residents: Find the currently active session
        $activeSession = ApplicationSession::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        if ($activeSession) {
            return redirect()->route('mainapplication', ['id' => $activeSession->id]);
        } else {
            return view('application.main_application', [
                'applications' => collect(),
                'session_id' => null,
                'hasApplied' => false,
                'totalAvailableSeat' => 0
            ]);
        }
    }

    public function mainResidentApplication()
    {
        $user = auth()->user();
        $active_session_id = ApplicationSession::where('is_active', true)->first();
        
        $hasApplied = Application::where('user_id', $user->id)
            ->where('session_id', $active_session_id->id ?? null)
            ->exists();

        // Check if there is any active semester at all
        $activeSemesterExists = Semester::where('is_active', true)->exists();

        if (!$activeSemesterExists) {
            // No active semester, so can't check acceptance properly
            $hasAcceptOffer = null;
        } else {
            // Active semester exists, check if user has accepted offer in that semester
            $hasAcceptOffer = Application::where('user_id', $user->id)
                ->where('acceptance', 'accepted')
                ->whereHas('session.semester', function ($query) {
                    $query->where('is_active', true);
                })
                ->exists();
        }

        $applications = Application::where('user_id', $user->id)->get();
        $acceptanceStart = $active_session_id?->acceptance_start_date;

        return view('application.main_application', compact('applications', 'active_session_id', 'hasApplied', 'hasAcceptOffer', 'acceptanceStart'));
    }

    public function mainApplication($id)
    {
        $user = auth()->user(); // Get the authenticated user
        $totalAvailableSeat = Room::where('status','available')->sum('capacity');
        $applications = Application::where('session_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $session_id = ApplicationSession::findOrFail($id);
        $active_session_id = ApplicationSession::where('is_active', true)->first();
        $hasAcceptOffer = null;
        $hasApplied = Application::where('session_id', $id)
        ->where('user_id', $user->id)
        ->exists();

        $matchPercentages = AllocationStatus::where('session_id', $session_id->id)
        ->pluck('overall_match_percentage','chunk_number');

        $overallMatchPercentage = $matchPercentages->count() > 0
        ? round($matchPercentages->avg(), 2) // e.g., 83.45
        : null;

        return view('application.main_application', compact(
            'applications',
            'active_session_id',
            'session_id',
            'hasAcceptOffer',
            'hasApplied',
            'totalAvailableSeat',
            'matchPercentages',
            'overallMatchPercentage'
        ));
    
        abort(403, 'Unauthorized action.');
    } 

    public function addApplication($id)
    {
        $availableBlocks = DB::table('rooms')
            ->select('block', 'gender')
            ->groupBy('block', 'gender') // ensures uniqueness per block-gender pair
            ->get();


        return view('application.add_application', compact('id', 'availableBlocks'));
    }

    public function storeApplication(Request $request)
    {
        $request->validate([
            'applicant_name' => 'required',
            'applicant_student_id' => 'required',
            'applicant_email' => 'required',
            'applicant_gender' => 'required',
            'applicant_faculty' => 'required', 
            'applicant_program' => 'required',
            'applicant_year_of_study' => 'required',
            'applicant_contact_no' => 'required',
            'applicant_address' => 'required',
            'applicant_reason' => 'required',
            'applicant_prefered_block' => 'required',
            'applicant_prefered_floor' => 'required',
            'applicant_prefered_room_type' => 'required',
            'application_session_id' => 'required|exists:application_sessions,id',
        ]);

        $application = new Application();
        
        $application->user_id = auth()->id(); // assuming the user is logged in
        $application->session_id = $request->application_session_id;
        $application->name = $request->applicant_name;
        $application->student_id = $request->applicant_student_id;
        $application->email = $request->applicant_email;
        $application->gender = $request->application_gender;
        $application->faculty = $request->applicant_faculty;
        $application->program = $request->applicant_program;
        $application->year_of_study = $request->applicant_year_of_study;
        $application->contact_no = $request->applicant_contact_no;
        $application->address = $request->applicant_address;
        $application->application_reason = $request->applicant_reason;
        $application->preferred_room_feature = json_encode([
            'block' => $request->applicant_prefered_block,
            'floor' => $request->applicant_prefered_floor,
            'room_type' => $request->applicant_prefered_room_type
        ]);

        $application->save();

        $notification = array(
            'message' => 'Application added successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('mainresidentapplication', ['id' => $request->application_session_id])->with($notification);
    }

    public function viewApplication($id)
    {
        $application = Application::with('session')->findOrFail($id); // eager load session

        // Extract session dates using the relationship
        $session = $application->session;

        $applicationStartDate = $session->application_start_date ?? null;
        $acceptance_start_date = $session->acceptance_start_date ?? null;
        $acceptanceEndDate = $session->acceptance_end_date ?? null;

        return view('application.approval_application', compact(
            'application',
            'applicationStartDate',
            'acceptance_start_date',
            'acceptanceEndDate'
        ));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'nullable|string|max:255',
        ]);

        $application = Application::findOrFail($id);
        $status = $request->input('status');

        $sessionId = $application->session_id;

        // Count approved applications for the session
        $approvedCount = Application::where('session_id', $sessionId)
            ->where('application_status', 'approved')
            ->count();

        // Get total available seats
        $totalAvailableSeats = Room::where('status', 'available')->sum('capacity');

        if ($status === 'approved') {
            // Prevent approval if no seats left
            if ($approvedCount >= $totalAvailableSeats) {
                return redirect()->back()->with('error', 'Cannot approve. No available seats left.');
            }

            $application->application_status = 'approved';
            $application->rejection_reason = null;
            // You may also want to reset acceptance here if needed
            // $application->acceptance = null;

        } elseif ($status === 'rejected') {
            $application->application_status = 'rejected';
            $application->rejection_reason = $request->input('rejection_reason');
            $application->acceptance = 'not_offered';
        }

        $application->save();

        // Auto-reject remaining pending applications if seats are full
        $updatedApprovedCount = Application::where('session_id', $sessionId)
            ->where('application_status', 'approved')
            ->count();

        if ($updatedApprovedCount >= $totalAvailableSeats) {
            Application::where('session_id', $sessionId)
                ->where('application_status', 'pending')
                ->update([
                    'application_status' => 'rejected',
                    'rejection_reason' => 'Application rejected automatically due to no available seats.',
                    'acceptance' => 'not_offered'
                ]);
        }

        $user = $application->user;
        $user->notify(new ApplicationStatusUpdated($status, $application->id));

        $notification = array (
            'message' => 'Application status updated successfully.',
            'alert-type' =>'success'
        );

        return redirect()->back()->with($notification);
    }

    public function updateAcceptanceStatus(Request $request, $id)
    {
        $request->validate([
            'acceptance_status' => 'required|in:accepted,rejected',
            'acceptance_rejection_reason' => 'nullable|string|max:255',
        ]);

        $application = Application::findOrFail($id);
        $status = $request->input('acceptance_status');

        if ($status === 'accepted') {
            $application->acceptance = 'accepted';
            $application->acceptance_reject_reason = null;

            $user = User::find($application->user_id);
            if ($user) {
                $this->promoteUserToResident($user, $application);
            }

        } elseif ($status === 'rejected') {
            $application->acceptance = 'rejected';
            $application->acceptance_reject_reason = $request->input('acceptance_rejection_reason');
        }

        $application->save();

        return redirect()->back()->with([
            'message' => 'Acceptance status updated successfully',
            'alert-type' => 'success'
        ]);
    }

    private function promoteUserToResident(User $user, Application $application)
    {
        // Step 1: Update usertype to 'resident'
        $user->usertype = 'resident';
        $user->save();

        $user->roles()->detach(); // Remove old roles like 'user'
        Bouncer::assign('resident')->to($user); // Assign new role

        $semesterId = optional($application->session)->semester_id;

        // Step 2: Create Resident record
        Resident::firstOrCreate(
            ['user_id' => $user->id,
                'semester_id' => $semesterId],
            [
                'application_id' => $application->id,
                'name' => $application->name,
                'student_id' => $application->student_id,
                'email' => $application->email,
                'contact_no' => $application->contact_no,
                'room_id' => $application->room_id,
                'semester_id' => $semesterId,
            ]
        );

        // Step 3: Update room occupancy
        $room = Room::find($application->room_id);
        if ($room) {
            $currentOccupy = (int) $room->occupy;
            $roomCapacity = (int) $room->capacity;

            // Only increment if not already full
            if ($currentOccupy < $roomCapacity) {
                $room->occupy = $currentOccupy + 1;

                // Optional: Mark room as full
                if ($room->occupy >= $roomCapacity) {
                    $room->status = 'unavailable'; // Or any other value you're using
                }

                $room->save();
            }
        }
    }

    public function downloadApplicationPDF($id)
    {
        $application = Application::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.application_form', compact('application'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('application_' . $application->student_id . '.pdf');
    }
    
    public function roomAllocation(Request $request, $id)
    {
        // Retrieve all approved applications filtered by session_id
        $applications = Application::where('application_status', 'approved')
            ->where('session_id', $id)
            ->get();

        $session_id = ApplicationSession::findOrFail($id);
        $chunks = $applications->chunk(50); // Chunk applications for pagination

        // Retrieve all statuses for this session, grouped by chunk number
        $statuses = AllocationStatus::where('session_id', $id)->get()->keyBy('chunk_number');

        $matchPercentages = AllocationStatus::where('session_id', $session_id->id)
            ->pluck('overall_match_percentage','chunk_number');

        // Return the view and pass the approved applications + statuses
        return view('application.main_room_allocation', compact('applications', 'session_id', 'chunks', 'statuses', 'matchPercentages'));
    }

    public function roomAllocationBatch($session_id, $chunk_index)
    {
        $session = ApplicationSession::findOrFail($session_id);

        $applications = Application::where('application_status', 'approved')
            ->where('session_id', $session_id)
            ->with('room')
            ->get();

        $chunks = $applications->chunk(50);
        $chunkIndex = $chunk_index - 1; // For array indexing (starts at 0)

        $chunkNumber = $chunk_index; // Actual chunk number for database

        if (!isset($chunks[$chunkIndex])) {
            abort(404, 'Batch not found');
        }

        $batchApplications = $chunks[$chunkIndex];

        // ✅ Get status for this session and chunk
        $status = AllocationStatus::where('session_id', $session_id)
                                ->where('chunk_number', $chunkNumber)
                                ->first();

        return view('application.room_allocation', compact(
            'batchApplications',
            'session',
            'chunkNumber',
            'status' // ✅ pass to view
        ));
    }

    // public function runRoomAllocationGA()
    // {
    //     // 1. Load approved applications without room assignment
    //     $applications = Application::where('application_status', 'approved')
    //         ->whereDoesntHave('resident') // Check if the application already has a resident
    //         ->get();

    //     // 2. Load available rooms and current occupancy
    //     $rooms = Room::where('status', 'available')->get();

    //     // Check if rooms are available
    //     if ($rooms->isEmpty()) {
    //         return redirect()->back()->with('error', 'No available rooms for allocation.');
    //     }

    //     // Step: Prepare chromosomes
    //     $populationSize = 50;  // Population size for genetic algorithm
    //     $generations = 30;  // Number of generations to run
    //     $mutationRate = 0.05;  // Probability of mutation

    //     $population = [];


    //     // Early stopping parameters
    //     $targetFitness = 90;         // 95 is a high match score (can adjust)
    //     $stagnationLimit = 5;        // Stop if no improvement for 5 gens
    //     $timeLimit = 300;             // 10 seconds

    //     $startTime = microtime(true);
    //     $noImprovementCounter = 0;
    //     $bestFitness = null;

    //     // Initialize population
    //     for ($i = 0; $i < $populationSize; $i++) {
    //         $chromosome = [];

    //         foreach ($applications as $application) {
    //             $room = $this->getRandomRoomForApplication($application, $rooms);
    //             $chromosome[$application->id] = $room ? $room->id : null;
    //         }

    //         $population[] = $chromosome;
    //     }

    //     // Step: Evolve generations
    //     for ($g = 0; $g < $generations; $g++) {
    //         // Step: Evaluate fitness
    //         // Sort by fitness descending
    //         usort($population, function ($a, $b) use ($applications, $rooms) {
    //             return $this->calculateFitness($b, $applications, $rooms)
    //                 <=> $this->calculateFitness($a, $applications, $rooms);
    //         });

    //         // Get current best fitness
    //         $currentBestFitness = $this->calculateFitness($population[0], $applications, $rooms);

    //         // Stop if target fitness is reached
    //         if ($currentBestFitness >= $targetFitness) {
    //             Log::info("Early stop: fitness threshold reached at generation $g.");
    //             break;
    //         }

    //         // Stagnation check
    //         if ($bestFitness === null || $currentBestFitness > $bestFitness) {
    //             $bestFitness = $currentBestFitness;
    //             $noImprovementCounter = 0;
    //         } else {
    //             $noImprovementCounter++;
    //         }

    //         if ($noImprovementCounter >= $stagnationLimit) {
    //             Log::info("Early stop: no improvement for $stagnationLimit generations.");
    //             break;
    //         }

    //         // Time limit check
    //         if ((microtime(true) - $startTime) > $timeLimit) {
    //             Log::info("Early stop: time limit of {$timeLimit}s exceeded at generation $g.");
    //             break;
    //         }

    //         // Step: Crossover (select top 50% parents to create children)
    //         $newPopulation = array_slice($population, 0, $populationSize / 2);

    //         while (count($newPopulation) < $populationSize) {
    //             $parent1 = $population[rand(0, $populationSize / 2 - 1)];
    //             $parent2 = $population[rand(0, $populationSize / 2 - 1)];
    //             $child = [];

    //             // Crossover: Randomly pick room allocation from each parent
    //             foreach ($applications as $application) {
    //                 $child[$application->id] = rand(0, 1)
    //                     ? $parent1[$application->id]
    //                     : $parent2[$application->id];
    //             }

    //             // Step: Mutation
    //             // if (rand() / getrandmax() < $mutationRate) {
    //             //     $randApp = $applications[rand(0, count($applications) - 1)];
    //             //     $child[$randApp->id] = $this->getRandomRoomForApplication($randApp, $rooms)?->id;
    //             // }
    //             if ($applications->isNotEmpty() && (rand() / getrandmax() < $mutationRate)) {
    //                 $randIndex = rand(0, $applications->count() - 1);
    //                 $randApp = $applications[$randIndex];

    //                 $room = $this->getRandomRoomForApplication($randApp, $rooms);
    //                 $child[$randApp->id] = $room ? $room->id : null;
    //             }

    //             $newPopulation[] = $child;
    //         }

    //         // Update population for the next generation
    //         $population = $newPopulation;
    //     }

        
    //       // Step: Apply best chromosome
    //     $bestSolution = $population[0];
    //     $totalMatchPercentage = 0;
    //     $matchedCount = 0;
    //     foreach ($bestSolution as $applicationId => $roomId) {
    //         if (!$roomId) continue;

    //         $application = $applications->firstWhere('id', $applicationId);
    //         $room = $rooms->firstWhere('id', $roomId);

    //         // Check if room still has capacity
    //         $assignedCount = Resident::where('room_id', $roomId)->count();
    //         if ($assignedCount < $room->capacity) {

    //             // Calculate match score for this allocation
    //             $pref = json_decode($application->preferred_room_feature, true);
    //             $matchScore = 0;
    //             $maxScore = 6; // 3+2+1 possible points

    //             // if ($room->room_type === $pref['room_type']) $matchScore += 3;
    //             // if ($room->block === $pref['block']) $matchScore += 2;
    //             // if ($room->floor === $pref['floor']) $matchScore += 1;

    //             if (strcasecmp($room->type, $pref['room_type']) === 0) $matchScore += 3;
    //             if (strcasecmp($room->block, $pref['block']) === 0) $matchScore += 2;
    //             if (strcasecmp($room->floor, $pref['floor']) === 0) $matchScore += 1;

    //             $matchPercentage = round(($matchScore / $maxScore) * 100, 2);

    //             // Create or update the resident record
    //             // Resident::updateOrCreate(
    //             //     ['user_id' => $application->user_id],
    //             //     [
    //             //         'application_id' => $application->id,
    //             //         'room_id'        => $roomId,
    //             //         'name'           => $application->name,
    //             //         'student_id'     => $application->student_id,
    //             //         'email'          => $application->email,
    //             //         'contact_no'     => $application->contact_no,
    //             //     ]
    //             // );

    //             $totalMatchPercentage += $matchPercentage;
    //             $matchedCount++;

    //             // Update application with allocated room type and match percentage
    //             $application->update([
    //                 'room_id' => $room->id, // now saving the actual room ID
    //                 'allocation_match_percentage' => $matchPercentage,
    //             ]);

    //         }
    //     }

    //     $overallMatchPercentage = $matchedCount > 0
    //     ? round($totalMatchPercentage / $matchedCount, 2)
    //     : 0;


    //     return redirect()->back()->with([
    //         'success' => 'Room allocation completed using Genetic Algorithm.',
    //         'match_percentage' => "Overall Match Percentage: $overallMatchPercentage%",
    //     ]);
    // }

    public function runRoomAllocationGA()
{
    // 1. Load approved applications without room assignment
    $applications = Application::where('application_status', 'approved')
        ->whereDoesntHave('resident')
        ->get();

    $rooms = Room::where('status', 'available')->get();

    if ($rooms->isEmpty()) {
        return redirect()->back()->with('error', 'No available rooms for allocation.');
    }

    // Pre-decode all application preferences
    $preferenceMap = $applications->mapWithKeys(fn($app) => [$app->id => json_decode($app->preferred_room_feature, true)]);

    // GA parameters
    $populationSize = 20;
    $maxGenerations = 20;
    $mutationRate = 0.05;
    $stagnationLimit = 5;
    $lastBestFitness = null;
    $stagnantCount = 0;

    // Initialize population
    $population = [];
    for ($i = 0; $i < $populationSize; $i++) {
        $chromosome = [];
        foreach ($applications as $app) {
            $room = $this->getRandomRoomForApplication($app, $rooms);
            $chromosome[$app->id] = $room ? $room->id : null;
        }
        $population[] = $chromosome;
    }

    for ($g = 0; $g < $maxGenerations; $g++) {
        // Evaluate and sort by fitness
        usort($population, fn($a, $b) =>
            $this->calculateFitness($b, $applications, $rooms, $preferenceMap)
            <=> $this->calculateFitness($a, $applications, $rooms, $preferenceMap));

        $currentBestFitness = $this->calculateFitness($population[0], $applications, $rooms, $preferenceMap);
        if ($lastBestFitness === $currentBestFitness) {
            $stagnantCount++;
        } else {
            $stagnantCount = 0;
        }
        if ($stagnantCount >= $stagnationLimit) break;
        $lastBestFitness = $currentBestFitness;

        // Crossover + Mutation
        $newPopulation = array_slice($population, 0, $populationSize / 2);
        while (count($newPopulation) < $populationSize) {
            $parent1 = $population[rand(0, $populationSize / 2 - 1)];
            $parent2 = $population[rand(0, $populationSize / 2 - 1)];
            $child = [];

            foreach ($applications as $app) {
                $child[$app->id] = rand(0, 1) ? $parent1[$app->id] : $parent2[$app->id];
            }

            if ($applications->isNotEmpty() && rand() / getrandmax() < $mutationRate) {
                $randApp = $applications[rand(0, count($applications) - 1)];
                $child[$randApp->id] = $this->getRandomRoomForApplication($randApp, $rooms)?->id;
            }

            $newPopulation[] = $child;
        }

        $population = $newPopulation;
    }

    // Apply best chromosome
    $bestSolution = $population[0];
    $totalMatchScore = 0;
    $matchedCount = 0;

    foreach ($bestSolution as $appId => $roomId) {
        if (!$roomId) continue;
        $application = $applications->firstWhere('id', $appId);
        $room = $rooms->firstWhere('id', $roomId);
        if (!$room) continue;

        $assigned = Resident::where('room_id', $roomId)->count();
        if ($assigned < $room->capacity) {
            $pref = $preferenceMap[$appId];
            $score = 0;

            if (strcasecmp($room->type, $pref['room_type']) === 0) $score += 3;
            if (strcasecmp($room->block, $pref['block']) === 0) $score += 2;
            if (strcasecmp($room->floor, $pref['floor']) === 0) $score += 1;

            $matchPercentage = round(($score / 6) * 100, 2);
            $totalMatchScore += $matchPercentage;
            $matchedCount++;

            $application->update([
                'room_id' => $room->id,
                'allocation_match_percentage' => $matchPercentage,
            ]);
        }
    }

    $overallMatch = $matchedCount > 0 ? round($totalMatchScore / $matchedCount, 2) : 0;

    return redirect()->back()->with('match_percentage', "Overall match: {$overallMatch}%");
}

private function calculateFitness($chromosome, $applications, $rooms, $preferenceMap)
{
    $score = 0;
    $occupancy = [];

    foreach ($chromosome as $appId => $roomId) {
        if (!$roomId) continue;

        $application = $applications->firstWhere('id', $appId);
        $room = $rooms->firstWhere('id', $roomId);
        if (!$room) continue;

        $pref = $preferenceMap[$appId];
        if (strcasecmp($room->type, $pref['room_type']) === 0) $score += 3;
        if (strcasecmp($room->block, $pref['block']) === 0) $score += 2;
        if (strcasecmp($room->floor, $pref['floor']) === 0) $score += 1;

        $occupancy[$roomId] = ($occupancy[$roomId] ?? 0) + 1;
        if ($occupancy[$roomId] > $room->capacity) $score -= 10;
    }

    return $score;
}

private function getRandomRoomForApplication($application, $rooms)
{
    return $rooms->isNotEmpty() ? $rooms->random() : null;
}

    // private function calculateFitness($chromosome, $applications, $rooms)
    // {
    //     $score = 0;
    //     $roomOccupancy = [];

    //     foreach ($chromosome as $applicationId => $roomId) {
    //         if (!$roomId) continue;

    //         $application = $applications->firstWhere('id', $applicationId);
    //         $room = $rooms->firstWhere('id', $roomId);

    //         if (!$room) continue;

    //         $pref = json_decode($application->preferred_room_feature, true);

    //         // Matching preference
    //         // if ($room->type === $pref['room_type']) $score += 3;
    //         // if ($room->block === $pref['block']) $score += 2;
    //         // if ($room->floor === $pref['floor']) $score += 1;

    //         if (strcasecmp($room->type, $pref['room_type']) === 0) $score += 3;
    //         if (strcasecmp($room->block, $pref['block']) === 0) $score += 2;
    //         if (strcasecmp($room->floor, $pref['floor']) === 0) $score += 1;

    //         // Capacity check
    //         $roomOccupancy[$roomId] = ($roomOccupancy[$roomId] ?? 0) + 1;
    //         if ($roomOccupancy[$roomId] > $room->capacity) {
    //             $score -= 10; // Penalize over-capacity
    //         }
    //     }

    //     return $score;
    // }

    // private function getRandomRoomForApplication($application, $rooms)
    // {
    //     $preferred = json_decode($application->preferred_room_feature, true);

    //     if (!$preferred) return null;

    //     // All available rooms
    //     $availableRooms = $rooms->filter(fn($room) => $room->status === 'available');

    //     return $availableRooms->isNotEmpty()
    //         ? $availableRooms->random()
    //         : null;
    // }

    public function confirmAllocation()
    {
        AllocationStatus::where('id', 1)->update([
            'is_confirmed' => true,
        ]);

        return redirect()->back()->with('message', 'Room allocation confirmed.');
    }

    
    public function deleteApplication($id)
    {
        $application_session = Application::findOrFail($id);
        $sessionId = $application_session->session_id;

        if (!$sessionId) {
            return redirect()->back()->with('error', 'Missing application session ID.');
        }

        $application_session->delete();

        $notification = [
            'message'    => 'Application deleted successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('mainapplication', ['id' => $sessionId])->with($notification);
    }

}

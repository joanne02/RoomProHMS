<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Room;
use App\Models\Resident;
use App\Models\ApplicationSession;

class RoomAllocationController extends Controller
{
    public function roomAllocation(Request $request, $id)
    {
        // Retrieve all approved applications filtered by session_id
        $applications = Application::where('application_status', 'approved')
            ->where('session_id', $id) // Filter by the session_id
            ->get();

        $session_id = ApplicationSession::findOrFail($id);

        // Return the view and pass the approved applications
        return view('application.room_allocation', compact('applications', 'session_id'));
    }

    public function runRoomAllocationGA()
    {
        // 1. Load approved applications without room assignment
        $applications = Application::where('application_status', 'approved')
            ->whereDoesntHave('resident') // Check if the application already has a resident
            ->get();

        // 2. Load available rooms and current occupancy
        $rooms = Room::where('status', 'available')->get();

        // Check if rooms are available
        if ($rooms->isEmpty()) {
            return redirect()->back()->with('error', 'No available rooms for allocation.');
        }

        // Step: Prepare chromosomes
        $populationSize = 50;  // Population size for genetic algorithm
        $generations = 100;  // Number of generations to run
        $mutationRate = 0.05;  // Probability of mutation

        $population = [];

        // Initialize population
        for ($i = 0; $i < $populationSize; $i++) {
            $chromosome = [];

            foreach ($applications as $application) {
                $room = $this->getRandomRoomForApplication($application, $rooms);
                $chromosome[$application->id] = $room ? $room->id : null;
            }

            $population[] = $chromosome;
        }

        // Step: Evolve generations
        for ($g = 0; $g < $generations; $g++) {
            // Step: Evaluate fitness
            usort($population, function ($a, $b) use ($applications, $rooms) {
                return $this->calculateFitness($b, $applications, $rooms)
                    <=> $this->calculateFitness($a, $applications, $rooms);
            });

            // Step: Crossover (select top 50% parents to create children)
            $newPopulation = array_slice($population, 0, $populationSize / 2);

            while (count($newPopulation) < $populationSize) {
                $parent1 = $population[rand(0, $populationSize / 2 - 1)];
                $parent2 = $population[rand(0, $populationSize / 2 - 1)];
                $child = [];

                // Crossover: Randomly pick room allocation from each parent
                foreach ($applications as $application) {
                    $child[$application->id] = rand(0, 1)
                        ? $parent1[$application->id]
                        : $parent2[$application->id];
                }

                // Step: Mutation
                // if (rand() / getrandmax() < $mutationRate) {
                //     $randApp = $applications[rand(0, count($applications) - 1)];
                //     $child[$randApp->id] = $this->getRandomRoomForApplication($randApp, $rooms)?->id;
                // }
                if ($applications->isNotEmpty() && (rand() / getrandmax() < $mutationRate)) {
                    $randIndex = rand(0, $applications->count() - 1);
                    $randApp = $applications[$randIndex];

                    $room = $this->getRandomRoomForApplication($randApp, $rooms);
                    $child[$randApp->id] = $room ? $room->id : null;
                }

                $newPopulation[] = $child;
            }

            // Update population for the next generation
            $population = $newPopulation;
        }

        
          // Step: Apply best chromosome
        $bestSolution = $population[0];
        foreach ($bestSolution as $applicationId => $roomId) {
            if (!$roomId) continue;

            $application = $applications->firstWhere('id', $applicationId);
            $room = $rooms->firstWhere('id', $roomId);

            // Check if room still has capacity
            $assignedCount = Resident::where('room_id', $roomId)->count();
            if ($assignedCount < $room->capacity) {

                // Calculate match score for this allocation
                $pref = json_decode($application->preferred_room_feature, true);
                $matchScore = 0;
                $maxScore = 6; // 3+2+1 possible points

                if ($room->room_type === $pref['room_type']) $matchScore += 3;
                if ($room->block === $pref['block']) $matchScore += 2;
                if ($room->floor === $pref['floor']) $matchScore += 1;

                $matchPercentage = round(($matchScore / $maxScore) * 100, 2);

                // Create or update the resident record
                // Resident::updateOrCreate(
                //     ['user_id' => $application->user_id],
                //     [
                //         'application_id' => $application->id,
                //         'room_id'        => $roomId,
                //         'name'           => $application->name,
                //         'student_id'     => $application->student_id,
                //         'email'          => $application->email,
                //         'contact_no'     => $application->contact_no,
                //     ]
                // );

                // Update application with allocated room type and match percentage
                $application->update([
                    'allocated_room_type' => $room->id, // now saving the actual room ID
                    'allocation_match_percentage' => $matchPercentage,
                ]);

            }
        }


        return redirect()->back()->with('success', 'Room allocation completed using Genetic Algorithm.');
    }

    private function calculateFitness($chromosome, $applications, $rooms)
    {
        $score = 0;
        $roomOccupancy = [];

        foreach ($chromosome as $applicationId => $roomId) {
            if (!$roomId) continue;

            $application = $applications->firstWhere('id', $applicationId);
            $room = $rooms->firstWhere('id', $roomId);

            if (!$room) continue;

            $pref = json_decode($application->preferred_room_feature, true);

            // Matching preference
            if ($room->type === $pref['room_type']) $score += 3;
            if ($room->block === $pref['block']) $score += 2;
            if ($room->floor === $pref['floor']) $score += 1;

            // Capacity check
            $roomOccupancy[$roomId] = ($roomOccupancy[$roomId] ?? 0) + 1;
            if ($roomOccupancy[$roomId] > $room->capacity) {
                $score -= 10; // Penalize over-capacity
            }
        }

        return $score;
    }

    private function getRandomRoomForApplication($application, $rooms)
    {
        $preferred = json_decode($application->preferred_room_feature, true);

        if (!$preferred) return null;

        // All available rooms
        $availableRooms = $rooms->filter(fn($room) => $room->status === 'available');

        return $availableRooms->isNotEmpty()
            ? $availableRooms->random()
            : null;
    }
}

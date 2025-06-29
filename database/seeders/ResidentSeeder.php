<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;
use App\Models\Resident;
use App\Models\Room;
use Carbon\Carbon;
use Silber\Bouncer\BouncerFacade as Bouncer;

class ResidentSeeder extends Seeder
{
    public function run(): void
    {
        $this->updateApplicationAcceptance();
        $this->promoteAcceptedApplicantsToResidents();
        $this->markAcceptanceNotified();
    }

    private function updateApplicationAcceptance(): void
    {
        $approvedApplications = Application::where('application_status', 'approved')
            ->where('session_id', 1)
            ->get();

        $approvedApplications = $approvedApplications->shuffle();

        $total = $approvedApplications->count();
        $acceptedCount = (int) round($total * 0.90);
        $rejectedCount = (int) round($total * 0.08);
        $notReviewedCount = $total - $acceptedCount - $rejectedCount;

        foreach ($approvedApplications as $i => $application) {
            if ($i < $acceptedCount) {
                $application->acceptance = 'accepted';
                $application->acceptance_reject_reason = null;
            } elseif ($i < $acceptedCount + $rejectedCount) {
                $application->acceptance = 'rejected';
                $application->acceptance_reject_reason = 'This is example acceptance reject reason for testing.';
            } else {
                $application->acceptance = 'Not Reviewed';
                $application->acceptance_reject_reason = null;
            }

            $application->save();
        }

        $this->command->info("Updated {$total} applications with acceptance statuses.");
    }

    private function promoteAcceptedApplicantsToResidents(): void
    {
        $applications = Application::where('acceptance', 'accepted')
            ->whereNotNull('room_id')
            ->whereHas('user')
            ->get();

        foreach ($applications as $application) {
            $user = $application->user;

            if (!$user || $user->usertype === 'resident') {
                continue;
            }

            // Step 1: Change usertype & role
            $user->usertype = 'resident';
            $user->save();

            $user->roles()->detach();
            Bouncer::assign('resident')->to($user);

            // Step 2: Create resident record
            $semesterId = optional($application->session)->semester_id;

            Resident::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'application_id' => $application->id,
                    'name' => $application->name,
                    'student_id' => $application->student_id,
                    'email' => $application->email,
                    'contact_no' => $application->contact_no,
                    'room_id' => $application->room_id,
                    'semester_id' => $semesterId,
                    'check_in' => Carbon::createFromTimestamp(
                        fake()->dateTimeBetween('2024-10-01', '2024-10-31')->getTimestamp()
                    ),
                ]
            );

            // Step 3: Update room
            $room = Room::find($application->room_id);
            if ($room) {
                $room->occupy = min($room->capacity, $room->occupy + 1);

                if ($room->occupy >= $room->capacity) {
                    $room->status = 'unavailable';
                }

                $room->save();
            }

            $this->command->info("Promoted {$user->email} to resident.");
        }
    }

    private function markAcceptanceNotified(): void
    {
        Application::where('session_id', 1)
            ->where('application_status', 'approved')
            ->where('acceptance', 'accepted')
            ->update(['acceptance_notified' => true]);

        $this->command->info("Marked acceptance_notified = true for accepted applications.");
    }



}

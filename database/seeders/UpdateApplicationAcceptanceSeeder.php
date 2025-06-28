<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;

class UpdateApplicationAcceptanceSeeder extends Seeder
{
    public function run(): void
    {
        // Get all approved applications
        $approvedApplications = Application::where('application_status', 'approved')
            ->where('session_id', 1)
            ->get();

        // Shuffle them for randomness
        $approvedApplications = $approvedApplications->shuffle();

        $total = $approvedApplications->count();

        $acceptedCount = (int) round($total * 0.90); // 90%
        $rejectedCount = (int) round($total * 0.08); // 8%
        $notReviewedCount = $total - $acceptedCount - $rejectedCount; // 2%

        $i = 0;

        foreach ($approvedApplications as $application) {
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
            $i++;
        }

        echo "Updated {$total} approved applications with acceptance status.\n";
    }
}

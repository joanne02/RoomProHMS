<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use App\Models\ApplicationSession;
use App\Notifications\ApplicationStatusUpdated;
use Carbon\Carbon;

class NotifyAcceptanceStart extends Command
{
    protected $signature = 'notify:acceptance-start';
    protected $description = 'Notify users when acceptance period starts';

    public function handle()
    {
        $now = \Carbon\Carbon::now();

        $sessions = \App\Models\ApplicationSession::where('acceptance_start_date', '<=', $now)->get();

        foreach ($sessions as $session) {
            $applications = \App\Models\Application::where('session_id', $session->id)
                ->where('application_status', 'approved')
                ->where('acceptance_notified', false) // only those not notified
                ->get();

            foreach ($applications as $application) {
                $user = $application->user;

                if ($user) {
                    $user->notify(new \App\Notifications\ApplicationStatusUpdated(
                        'approved',
                        $application->id,
                        'The acceptance period for your hostel application has started. Please log in to confirm your spot.'
                    ));

                    // mark as notified
                    $application->acceptance_notified = true;
                    $application->save();
                }
            }
        }

        $this->info('Acceptance start notifications sent.');
    }

}

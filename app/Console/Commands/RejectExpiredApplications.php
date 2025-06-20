<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApplicationSession;

class RejectExpiredApplications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reject-expired-applications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        $expiredApplications = ApplicationSession::whereNull('acceptance')
            ->whereHas('session', function ($query) use ($now) {
                $query->whereNotNull('application_end_date')
                    ->where('application_end_date', '<', $now);
            })
            ->get();

        foreach ($expiredApplications as $application) {
            $application->acceptance = 'rejected';
            $application->acceptance_reject_reason = 'Application expired';
            $application->save();
        }
        $this->info('Expired applications have been rejected successfully.');
    }
}

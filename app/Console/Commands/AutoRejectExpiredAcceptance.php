<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use Carbon\Carbon;

class AutoRejectExpiredAcceptance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-reject-expired-acceptance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-reject or mark as not reviewed if applicant did not respond within acceptance period';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $applications = Application::where('acceptance', 'pending')
            ->whereHas('session', function ($query) use ($now) {
                $query->where('acceptance_end_date', '<', $now);
            })->get();

        foreach ($applications as $application) {
            // You can choose either 'rejected' or 'not reviewed'
            $application->acceptance = 'not reviewed';
            $application->acceptance_reject_reason = 'Offer expired due to no response.';
            $application->save();
        }

        $this->info('Expired application offers processed successfully.');
    }
}

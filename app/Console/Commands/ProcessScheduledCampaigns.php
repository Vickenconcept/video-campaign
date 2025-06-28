<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailCampaign;
use App\Jobs\SendEmailCampaignJob;
use Carbon\Carbon;

class ProcessScheduledCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:process-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled email campaigns that are due to be sent';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for scheduled campaigns...');

        // Find campaigns that are scheduled and due to be sent
        $scheduledCampaigns = EmailCampaign::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->get();

        if ($scheduledCampaigns->isEmpty()) {
            $this->info('No scheduled campaigns found that are due to be sent.');
            
            // Show some debugging info
            $allScheduled = EmailCampaign::where('status', 'scheduled')->get();
            if (!$allScheduled->isEmpty()) {
                $this->info('Current time: ' . now()->format('Y-m-d H:i:s'));
                $this->info('Scheduled campaigns found:');
                foreach ($allScheduled as $campaign) {
                    $this->line("- {$campaign->title}: {$campaign->scheduled_at->format('Y-m-d H:i:s')} (Past due: " . ($campaign->scheduled_at->isPast() ? 'Yes' : 'No') . ")");
                }
            }
            return;
        }

        $this->info("Found {$scheduledCampaigns->count()} scheduled campaign(s) due to be sent.");

        foreach ($scheduledCampaigns as $campaign) {
            $this->info("Processing campaign: {$campaign->title} (ID: {$campaign->id})");
            
            try {
                // Dispatch the job immediately since it's already past the scheduled time
                SendEmailCampaignJob::dispatch($campaign);
                
                $this->info("✓ Job dispatched for campaign: {$campaign->title}");
            } catch (\Exception $e) {
                $this->error("✗ Failed to dispatch job for campaign {$campaign->title}: " . $e->getMessage());
            }
        }

        $this->info('Scheduled campaigns processing completed.');
    }
} 
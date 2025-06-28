<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailCampaign;
use Carbon\Carbon;

class CheckScheduledCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:check-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the status of scheduled email campaigns';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking scheduled campaigns...');
        
        // All campaigns with scheduled_at
        $allScheduled = EmailCampaign::whereNotNull('scheduled_at')->get();
        
        if ($allScheduled->isEmpty()) {
            $this->info('No campaigns with scheduled_at found.');
            return;
        }
        
        $this->info("Found {$allScheduled->count()} campaign(s) with scheduled_at:");
        
        foreach ($allScheduled as $campaign) {
            $status = $campaign->status;
            $scheduledAt = $campaign->scheduled_at;
            $isPastDue = $scheduledAt->isPast();
            $recipientsCount = $campaign->recipients()->count();
            
            $this->line("ID: {$campaign->id}");
            $this->line("Title: {$campaign->title}");
            $this->line("Status: {$status}");
            $this->line("Scheduled: {$scheduledAt->format('Y-m-d H:i:s')}");
            $this->line("Past Due: " . ($isPastDue ? 'Yes' : 'No'));
            $this->line("Recipients: {$recipientsCount}");
            $this->line("---");
        }
        
        // Check for campaigns that should have been sent
        $pastDue = EmailCampaign::where('status', 'scheduled')
            ->where('scheduled_at', '<=', Carbon::now())
            ->get();
            
        if (!$pastDue->isEmpty()) {
            $this->warn("Found {$pastDue->count()} campaign(s) that are past due and should be sent:");
            foreach ($pastDue as $campaign) {
                $this->warn("- {$campaign->title} (ID: {$campaign->id}) - Scheduled: {$campaign->scheduled_at->format('Y-m-d H:i:s')}");
            }
        }
    }
} 
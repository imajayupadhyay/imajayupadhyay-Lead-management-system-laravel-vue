<?php

namespace App\Console\Commands;

use App\Models\FollowUp;
use App\Models\Notification;
use Illuminate\Console\Command;

class GenerateFollowUpNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:follow-ups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate notifications for today\'s and overdue follow-ups';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating follow-up notifications...');

        // Get today's follow-ups
        $todayFollowUps = FollowUp::with('lead')
            ->where('status', 'Pending')
            ->whereDate('follow_up_date', today())
            ->get();

        // Get overdue follow-ups
        $overdueFollowUps = FollowUp::with('lead')
            ->where('status', 'Pending')
            ->where('follow_up_date', '<', today())
            ->get();

        $todayCount = 0;
        $overdueCount = 0;

        // Create notifications for today's follow-ups
        foreach ($todayFollowUps as $followUp) {
            // Check if notification already exists for today
            $exists = Notification::where('counselor_id', $followUp->counselor_id)
                ->where('type', 'follow_up_today')
                ->where('data->follow_up_id', $followUp->id)
                ->whereDate('created_at', today())
                ->exists();

            if (!$exists) {
                Notification::createFollowUpToday(
                    $followUp->counselor_id,
                    $followUp->id,
                    $followUp->lead->student_name
                );
                $todayCount++;
            }
        }

        // Create notifications for overdue follow-ups
        foreach ($overdueFollowUps as $followUp) {
            // Check if notification already exists for today
            $exists = Notification::where('counselor_id', $followUp->counselor_id)
                ->where('type', 'follow_up_overdue')
                ->where('data->follow_up_id', $followUp->id)
                ->whereDate('created_at', today())
                ->exists();

            if (!$exists) {
                Notification::createFollowUpOverdue(
                    $followUp->counselor_id,
                    $followUp->id,
                    $followUp->lead->student_name
                );
                $overdueCount++;
            }
        }

        $this->info("Created {$todayCount} notifications for today's follow-ups");
        $this->info("Created {$overdueCount} notifications for overdue follow-ups");
        $this->info('Done!');

        return 0;
    }
}

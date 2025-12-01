<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\User;
use App\Notifications\ScheduleReminder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SendScheduleReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:schedule-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to lecturers and students 5 hours before their scheduled classes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for upcoming schedules...');
        
        // Get current day name and time
        $now = Carbon::now();
        $targetTime = $now->copy()->addHours(5);
        
        // Get current day name in Indonesian format
        $dayNames = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $currentDayEnglish = $targetTime->format('l');
        $currentDay = $dayNames[$currentDayEnglish] ?? $currentDayEnglish;
        
        // Find schedules for today that start around 5 hours from now
        $schedules = Schedule::with(['course', 'lecturer1.user', 'lecturer2.user', 'room', 'timeslot'])
            ->whereHas('timeslot', function($query) use ($currentDay, $targetTime) {
                $query->where('day', $currentDay);
                
                // Get schedules that start within the next 5-6 hours
                $targetStartTime = $targetTime->format('H:i:s');
                $targetEndTime = $targetTime->copy()->addHour()->format('H:i:s');
                
                $query->where('start_time', '>=', $targetStartTime)
                      ->where('start_time', '<', $targetEndTime);
            })
            ->get();
        
        $this->info("Found {$schedules->count()} schedule(s) starting in approximately 5 hours.");
        
        $notificationsSent = 0;
        
        foreach ($schedules as $schedule) {
            // Send notification to lecturer 1
            if ($schedule->lecturer1 && $schedule->lecturer1->user) {
                if ($this->sendNotification($schedule, $schedule->lecturer1->user, 'dosen')) {
                    $notificationsSent++;
                }
            }
            
            // Send notification to lecturer 2 if exists
            if ($schedule->lecturer2 && $schedule->lecturer2->user) {
                if ($this->sendNotification($schedule, $schedule->lecturer2->user, 'dosen')) {
                    $notificationsSent++;
                }
            }
            
            // Send notifications to students in this class
            $students = Student::with('user')
                ->where('class_name', $schedule->class_name)
                ->get();
            
            foreach ($students as $student) {
                if ($student->user) {
                    if ($this->sendNotification($schedule, $student->user, 'mahasiswa')) {
                        $notificationsSent++;
                    }
                }
            }
        }
        
        $this->info("Successfully sent {$notificationsSent} notification(s).");
        
        return Command::SUCCESS;
    }
    
    /**
     * Send notification to a user if not already sent
     */
    private function sendNotification($schedule, $user, $role)
    {
        // Check if notification already sent
        $alreadySent = DB::table('schedule_notifications')
            ->where('schedule_id', $schedule->id)
            ->where('user_id', $user->id)
            ->where('notification_type', 'schedule_reminder')
            ->exists();
        
        if ($alreadySent) {
            return false;
        }
        
        try {
            // Send notification
            $user->notify(new ScheduleReminder($schedule, $role));
            
            // Record notification
            DB::table('schedule_notifications')->insert([
                'schedule_id' => $schedule->id,
                'user_id' => $user->id,
                'notification_type' => 'schedule_reminder',
                'sent_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->line("✓ Sent to {$user->name} ({$user->email})");
            return true;
        } catch (\Exception $e) {
            $this->error("✗ Failed to send to {$user->name}: " . $e->getMessage());
            return false;
        }
    }
}

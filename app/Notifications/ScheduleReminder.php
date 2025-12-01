<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ScheduleReminder extends Notification
{
    use Queueable;

    protected $schedule;
    protected $userRole;

    /**
     * Create a new notification instance.
     */
    public function __construct($schedule, $userRole)
    {
        $this->schedule = $schedule;
        $this->userRole = $userRole;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $schedule = $this->schedule;
        $timeslot = $schedule->timeslot;
        $course = $schedule->course;
        $room = $schedule->room;
        
        // Format day and time
        $dayName = $timeslot->day;
        $startTime = date('H:i', strtotime($timeslot->start_time));
        $endTime = date('H:i', strtotime($timeslot->end_time));
        
        // Build lecturer names
        $lecturerNames = $schedule->lecturer1->user->name;
        if ($schedule->lecturer2) {
            $lecturerNames .= ' & ' . $schedule->lecturer2->user->name;
        }
        
        $message = (new MailMessage)
            ->subject('Pengingat Jadwal Kuliah - ' . $course->name);
        
        if ($this->userRole === 'dosen') {
            $message->greeting('Halo ' . $notifiable->name . ',')
                ->line('Anda memiliki jadwal mengajar dalam 5 jam.')
                ->line('**Detail Jadwal:**')
                ->line('📚 Mata Kuliah: **' . $course->name . '**')
                ->line('🏫 Ruangan: **' . $room->name . '**')
                ->line('📅 Hari: **' . $dayName . '**')
                ->line('🕐 Waktu: **' . $startTime . ' - ' . $endTime . '**')
                ->line('👥 Kelas: **' . $schedule->class_name . '**');
        } else {
            $message->greeting('Halo ' . $notifiable->name . ',')
                ->line('Anda memiliki jadwal kuliah dalam 5 jam.')
                ->line('**Detail Jadwal:**')
                ->line('📚 Mata Kuliah: **' . $course->name . '**')
                ->line('👨‍🏫 Dosen: **' . $lecturerNames . '**')
                ->line('🏫 Ruangan: **' . $room->name . '**')
                ->line('📅 Hari: **' . $dayName . '**')
                ->line('🕐 Waktu: **' . $startTime . ' - ' . $endTime . '**');
        }
        
        $message->line('Pastikan Anda sudah siap dan tidak terlambat.')
            ->salutation('Terima kasih, Tim SiJaDu');
        
        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'schedule_id' => $this->schedule->id,
            'course_name' => $this->schedule->course->name,
            'time' => $this->schedule->timeslot->start_time,
        ];
    }
}

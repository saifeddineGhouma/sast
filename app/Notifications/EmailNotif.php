<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailNotif extends Notification
{
    use Queueable;

    protected $user;
    protected $course;
    protected $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$course,$order)
    {
        $this->user 	= $user;
        $this->course 	= $course;
        $this->order 	= $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->view(
            'emails.email_notif', [
                'user_name' => $this->user->full_name_ar,
                'course_id' => $this->course->id
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [];
    }
}

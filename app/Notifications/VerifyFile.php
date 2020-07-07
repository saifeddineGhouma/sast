<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyFile extends Notification
{
    use Queueable;

    protected $username;
    protected $course_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($course_id, $username)
    {

        $this->course_id = $course_id;
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
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
            'emails.varify_file',
            ['course_id' => $this->course_id, 'username' => $this->username]
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
        return [
            "exams" => [
                "username" => $this->username,
                "course_id" => $this->course_id
            ]
        ];
    }
}

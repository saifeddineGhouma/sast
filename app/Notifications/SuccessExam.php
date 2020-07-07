<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SuccessExam extends Notification
{
    use Queueable;

    protected $examName;
    protected $username;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($username,$examName)
    {
        $this->username = $username;
        $this->examName = $examName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            'emails.success_exam', [
                'username' => $this->username,'examName'=>$this->examName
            ]
        );
    }

}

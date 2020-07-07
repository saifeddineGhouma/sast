<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserReview extends Notification
{
    use Queueable;

    protected $username;
    protected $comment;
    protected $courseName;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($username,$comment,$courseName)
    {
        $this->username = $username;
        $this->comment = $comment;
        $this->courseName = $courseName;
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
            'emails.user_review', [
                'name' => $this->username,'comment'=>$this->comment,'courseName'=>$this->courseName
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
        return [
            "userreview"=>[
                "comment"=>$this->comment,
                "username"=>$this->username,
                "courseName"=>$this->courseName
             ]
        ];
    }

}

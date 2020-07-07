<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CourseNotification extends Notification
{
    use Queueable;

    protected $username;
    protected $courseName;
    protected $days;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($username,$courseName,$days)
    {
        $this->username 	= $username;
        $this->courseName 	= $courseName;
        $this->days 		= $days;
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
            'emails.course_notification', [
                'username' => $this->username,'courseName'=>$this->courseName,'days'=>$this->days,
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
            "coursenotification"=>[
                "username"=>$this->username,
                "courseName"=>$this->courseName,
                "days"=>$this->days
             ]
        ];
    }

}

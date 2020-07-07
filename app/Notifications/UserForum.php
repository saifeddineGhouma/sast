<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserForum extends Notification
{
    use Queueable;

    protected $username;
    protected $forum_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($username,$forum_id)
    {
        $this->username = $username;
        $this->forum_id = $forum_id;
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
            'emails.user_forum', [
                'name' => $this->username,'forum_id'=>$this->forum_id
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
            "userforum"=>[
                "id"=>$this->forum_id,
                "username"=>$this->username
             ]
        ];
    }

}

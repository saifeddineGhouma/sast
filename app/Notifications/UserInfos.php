<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserInfos extends Notification
{
    use Queueable;

    protected $user_id;
    protected $username;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id,$username)
    {
        $this->user_id = $user_id;
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
        return ['database'];
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
            "userinfos"=>[
                "id"=>$this->user_id,
                "username"=>$this->username
             ]
        ];
    }
}

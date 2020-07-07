<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BirthdayNotification extends Notification
{
    use Queueable;

    protected $name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $coupon_code)
    {
        $this->name = $name;
        $this->coupon_code = $coupon_code;
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
            'emails.birthday', [
                'name' => $this->name,'coupon_code'=>$coupon_code
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
                'name' => $this->name
             ]
        ];
    }

}

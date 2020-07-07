<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class CourseStudy extends Notification
{
    use Queueable;

    protected $order_id;
    protected $total;
    protected $username;
    protected $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order_id, $total, $username, $order)
    {
        $this->order_id = $order_id;
        $this->total = $total;
        $this->username = $username;
        $this->order = $order;
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
        $user = User::where('username', $this->username)->first();
        $user_id = $user->id;
        return (new MailMessage)->view(
            'emails.course_study',
            [
                'orderId' => $this->order_id, 'total' => $this->total, 'order' => $this->order, 'user_id' => $user_id, 'name' => $this->username
            ]
        );
        // $email =  (new MailMessage)->view(
        //     'emails.course_study',
        //     [
        //         'orderId' => $this->order_id, 'total' => $this->total, 'order' => $this->order, 'user_id' => $user_id
        //     ]
        // );

        // // $files = "uploads/kcfinder/upload/file/" . $this->order->course->courseStudies->url;
        // foreach ($this->order->course->courseStudies as $courseStudies) {

        //     $email->attach("uploads/kcfinder/upload/file/" . $courseStudies->url);
        // }
        // return $email;
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
            "CourseStudy" => [
                "id" => $this->order_id,
                "total" => $this->total,
                "username" => $this->username
            ]
        ];
    }
}

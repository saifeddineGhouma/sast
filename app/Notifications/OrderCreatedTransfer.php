<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class OrderCreatedTransfer extends Notification
{
    use Queueable;

    protected $order_id;
    protected $total;
    protected $username;
    protected $order;
    protected $provider;
    protected $ref;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order_id, $total, $username, $order, $provider = null, $ref = null)
    {
        $this->order_id = $order_id;
        $this->total    = $total;
        $this->username = $username;
        $this->order    = $order;
        $this->provider = $provider;
        $this->ref      = $ref;
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
            'emails.new_order_transfer',
            [
                'orderId' => $this->order_id, 'order' => $this->order, 'username' => $this->username, 'provider' => $this->provider, 'ref' => $this->ref
            ]
        );
    }
    // ->attach(("https://www.swedish-academy.se/uploads/kcfinder/upload/file/summaries/Summary%20strategic%20management.pdf"), [
    //     'as' => 'filename.pdf',
    //     'mime' => 'text/pdf'
    // ])
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            "OrderCreatedTransfer" => [
                "id" => $this->order_id,
                "total" => $this->total,
                "username" => $this->username
            ]
        ];
    }
}

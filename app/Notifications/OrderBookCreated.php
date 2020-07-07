<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class OrderBookCreated extends Notification
{
    use Queueable;

    protected $order_id;
    protected $total;
    protected $username;
    protected $order;
    protected $pdf_book;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order_id, $total, $username, $order, $pdf_book)
    {
        $this->order_id = $order_id;
        $this->total = $total;
        $this->username = $username;
        $this->order = $order;
        $this->pdf_book = $pdf_book;
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
            'emails.new_order_book',
            [
                'orderId' => $this->order_id, 'total' => $this->total, 'order' => $this->order, 'user_id' => $user_id, 'pdf_book' => $this->pdf_book, 'name' => $this->username
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
            "orderBookcreated" => [
                "id" => $this->order_id,
                "total" => $this->total,
                "username" => $this->username
            ]
        ];
    }
}

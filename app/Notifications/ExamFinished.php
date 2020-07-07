<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExamFinished extends Notification
{
    use Queueable;

    protected $username;
    protected $exam_id;
    protected $type;
    protected $exam_name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($username,$exam_id,$type,$exam_name)
    {
        $this->username = $username;
        $this->exam_id = $exam_id;
        $this->type = $type;
        $this->exam_name = $exam_name;
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
        $lien = 'https://swedish-academy.se/admin/students-exams/'.$this->exam_id.'/edit?type='.$this->type;
        return (new MailMessage)->view(
            'emails.exam_finished', [ 'lien' => $lien]
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
            "exams"=>[
                "username"=>$this->username,
                "exam_id"=>$this->exam_id,
                "type"=>$this->type,
                "exam_name"=>$this->exam_name
             ]
        ];
    }

}

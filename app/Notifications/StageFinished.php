<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StageFinished extends Notification
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
    public function __construct($username,$studentStage)
    {
        $this->username = $username;
        $this->studentStage = $studentStage;
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
        $lien = 'https://swedish-academy.se/admin/students-stage-edit/'.$this->studentStage->id;
        return (new MailMessage)->view(
            'emails.stage_finished', [ 'lien' => $lien]
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
                "exam_id"=>$this->studentStage->id
             ]
        ];
    }

}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;
    private $details;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details)
    {
         $this->details = $details;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Subject')
                    //->greeting('Hello!')
                    ->greeting($this->details['greeting'])
                    //->line('The introduction to the notification.')
                    ->line($this->details['body'])
                    //->action('Notification Action', url('/'))
                    ->action($this->details['actionText'], $this->details['actionURL'])
                    //->line('Thank you for using our application!');
                    ->line($this->details['thanks']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //'data' => 'this is my notification',
            'data' => "Data Id:- ".$this->details['data_id'],
            'actionURL' => $this->details['actionURL'],
            'body' => $this->details['body'],
            'greeting' => $this->details['greeting'],
        ];
    }
}

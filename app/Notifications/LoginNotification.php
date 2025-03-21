<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;
    private $details;

    /**
     * Create a new notification instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line("Welcome back! {$notifiable->first_name} ✈")
            ->action('Good to see you again! Your trips, bookings, and rewards are just a tap away.', url('/'))
            ->line('Didn’t sign in? If this wasn’t you, please reset your password immediately to keep your account secure.')
            ->line("Safe travel,")
            ->line("Airpeace Team");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

     /**
     * Define the array to be stored in the database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->details['title'],
            'body' => $this->details['body'],
            'url' => $this->details['url'],
            'user_id' => $notifiable->id,
        ];
    }

    /**
     * Get the Firebase representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toFirebase($notifiable)
    {
        return [
            'title' => 'Item Recall Notification',
            'body' => "The item ",
            'data' => [
                'item_name' => "Data",
                'recall_reason' => "Data",
                'action_url' => url('/recalls'),
            ],
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactSupport extends Notification
{
    use Queueable;

    protected $details;
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
             ->subject('Customer Complaint ✈')
            ->view('emails.support-mail', [
                'details' => $this->details,
            ]);
        // return (new MailMessage)
        //             ->line('Support Mail')
        //             ->line('Issue Details')
        //             ->line("email : {$this->details['email']}")
        //             ->line("booking ref : {$this->details['booking_reference']}")
        //             ->line("name on ticket : {$this->details['name_on_ticket']}")
        //             ->line("description : {$this->details['date_of_occurence']}")
        //             ->line("category : {$this->details['category']}");
                
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
}

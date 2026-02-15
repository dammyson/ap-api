<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $bookOriginDestinationOptionList;
    protected $airTravelerList;
    protected $specialRequestDetails;
    protected $ticketItemList;

    public function __construct($bookOriginDestinationOptionList, $airTravelerList, $specialRequestDetails, $ticketItemList)
    {
        $this->bookOriginDestinationOptionList = $bookOriginDestinationOptionList;
        $this->airTravelerList = $airTravelerList;
        $this->specialRequestDetails = $specialRequestDetails;
        $this->ticketItemList = $ticketItemList;
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

    $pdf = Pdf::loadView('pdfs.ticket-reservation', [
            'bookOriginDestinationOptionList' => $this->bookOriginDestinationOptionList,
            'airTravelerList' => $this->airTravelerList,
            'specialRequestDetails' => $this->specialRequestDetails,
            'ticketItemList' => $this->ticketItemList
        ]);
        
        
        // return (new MailMessage)
        //             ->subject('Airpeace Electionic Ticket Reservation Passenger Receipt  🕊')
        //             ->line("Hi {$notifiable->first_name}  🕊 ")
        //             ->line("Payment for your flight was successful")
        //             ->line('Please find attached your e-ticket for reservation details')
        //             ->attachData($pdf->output(), 'ticket-reservation.pdf', [
        //                 'mime' => 'application/pdf',
        //             ])
        //             ->line("Safe travel,")
        //             ->line('Airpeace Team');

        return (new MailMessage)
            ->subject('Airpeace Electronic Ticket Reservation Passenger Receipt 🕊')
            ->view('emails.reservation', [
                'name' => $notifiable->first_name ?? "Guest User",
            ])
            ->attachData($pdf->output(), 'ticket-reservation.pdf', [
                'mime' => 'application/pdf',
            ]);

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

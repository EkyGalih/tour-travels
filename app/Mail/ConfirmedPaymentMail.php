<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmedPaymentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;
    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the message envelope.
     */
    public function build(): self
    {
        return $this
            ->subject('Payment Confirmed')
            ->to(
                $this->booking->user->email,
                $this->booking->user->name
            )
            ->view('emails.payments.payment-confirmed', [
                'booking' => $this->booking,
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

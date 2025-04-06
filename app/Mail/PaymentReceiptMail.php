<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $client;
    public $vehicle;
    public $pdf;
    /**
     * Create a new message instance.
     */
    public function __construct($payment, $client, $vehicle, $pdf)
    {
        $this->payment = $payment;
        $this->client = $client;
        $this->vehicle = $vehicle;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Recibo de Pago')
            ->view('emails.payment-receipt')
            ->attachData($this->pdf, 'ReciboPago.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}

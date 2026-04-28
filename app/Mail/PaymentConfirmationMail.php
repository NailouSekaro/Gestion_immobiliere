<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->subject('Confirmation de paiement - ' . config('app.name'))
                    ->view('emails.payment-confirmation')
                    ->with([
                        'user' => $this->payment->user,
                        'property' => $this->payment->property,
                        'payment' => $this->payment
                    ]);
    }
}

<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $daysOverdue;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->daysOverdue = now()->diffInDays($payment->date_limite);
    }

    public function build()
    {
        $subject = $this->payment->estEnRetard()
            ? '⚠️ Rappel de paiement en retard - ' . config('app.name')
            : '📅 Rappel de paiement - ' . config('app.name');

        return $this->subject($subject)
                    ->view('emails.payment-reminder')
                    ->with([
                        'payment' => $this->payment,
                        'daysOverdue' => $this->daysOverdue,
                        'amountWithPenalty' => $this->payment->montant_avec_penalite
                    ]);
    }
}

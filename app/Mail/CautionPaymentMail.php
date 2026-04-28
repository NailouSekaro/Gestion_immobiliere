<?php

namespace App\Mail;

use App\Models\Caution;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CautionPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public Caution $caution;

    public function __construct(Caution $caution)
    {
        $this->caution = $caution;
    }

    public function build()
    {
        return $this->subject('Confirmation de paiement de caution')
            ->view('emails.caution-confirmation')
            ->with([
                'caution' => $this->caution
            ]);
    }
}

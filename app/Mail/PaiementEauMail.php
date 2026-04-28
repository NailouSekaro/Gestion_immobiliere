<?php

namespace App\Mail;

use App\Models\ConsommationEau;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaiementEauMail extends Mailable
{
    use Queueable, SerializesModels;

    public ConsommationEau $consommationEau;

    /**
     * Create a new message instance.
     */
    public function __construct(ConsommationEau $consommationEau)
    {
        $this->consommationEau = $consommationEau;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Confirmation de paiement de votre consommation d’eau')
            ->view('emails.paiement-eau')
            ->with([
                'consommationEau' => $this->consommationEau
            ]);
    }
}

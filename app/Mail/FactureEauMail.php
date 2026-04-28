<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ConsommationEau;

class FactureEauMail extends Mailable
{
    // public function __construct(public ConsommationEau $consommationEau) {}

    public ConsommationEau $consommationEau;

    public function __construct(ConsommationEau $consommationEau)
    {
        $this->consommationEau = $consommationEau;
    }


    public function build()
    {
        return $this->subject('Facture de consommation d’eau')
            ->view('emails.facture-eau');
    }
}

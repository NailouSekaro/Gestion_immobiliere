<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;
    public $user;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->resetUrl = route('password.reset', $token);
    }

    public function build()
    {
        return $this->subject('Réinitialisation de votre mot de passe - ' . config('app.name'))
                    ->view('emails.password-reset');
    }
}

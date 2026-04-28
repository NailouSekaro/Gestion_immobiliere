<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tempPassword;
    public $loginUrl;

    public function __construct(User $user, string $tempPassword)
    {
        $this->user = $user;
        $this->tempPassword = $tempPassword;
        $this->loginUrl = route('login');
    }

    public function build()
    {
        return $this->subject('Votre compte a été créé - ' . config('app.name'))
                    ->view('emails.user-created');
    }
}

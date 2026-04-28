<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class NewMessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function build()
    {
        return $this->subject('Nouveau message - ' . config('app.name'))
                    ->markdown('emails.new-message-notification')
                    ->with([
                        'expediteur' => $this->message->expediteur,
                        'sujet' => $this->message->sujet,
                        'contenu' => Str::limit($this->message->contenu, 100),
                        'messageUrl' => route('messages.show', $this->message)
                    ]);
    }
}

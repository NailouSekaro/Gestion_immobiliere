<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MessagePolicy
{
    public function view(User $user, Message $message)
    {
        return $message->expediteur_id === $user->id || $message->destinataire_id === $user->id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas accès à ce message.');
    }

    public function delete(User $user, Message $message)
    {
        return $message->expediteur_id === $user->id || $message->destinataire_id === $user->id
            ? Response::allow()
            : Response::deny('Vous ne pouvez pas supprimer ce message.');
    }
}

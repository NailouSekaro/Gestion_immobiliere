<?php

namespace App\Console\Commands;

use App\Models\Message;
use Illuminate\Console\Command;

class PopulateConversationIds extends Command
{
    protected $signature = 'messages:populate-conversations';
    protected $description = 'Populate conversation_id for existing messages';

    public function handle()
    {
        $this->info('Mise à jour des conversation_id pour les messages existants...');

        $messages = Message::whereNull('conversation_id')->get();
        $count = 0;

        foreach ($messages as $message) {
            $conversationId = Message::generateConversationId(
                $message->expediteur_id,
                $message->destinataire_id
            );

            $message->update(['conversation_id' => $conversationId]);
            $count++;
        }

        $this->info("✅ {$count} messages mis à jour avec succès !");

        return Command::SUCCESS;
    }
}

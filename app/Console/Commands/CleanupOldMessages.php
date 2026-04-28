<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;

class CleanupOldMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-old-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoff = now()->subYear(); // Supprime les messages de plus d'un an

        Message::where('created_at', '<', $cutoff)->delete();

        $this->info('Messages anciens nettoyés avec succès.');
    }
}

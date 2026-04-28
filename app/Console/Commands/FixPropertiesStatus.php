<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Property;

class FixPropertiesStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-properties-status';

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
    $properties = Property::with('locataireActuel')->get();

    foreach ($properties as $property) {
        $property->updateStatut();
    }

    $this->info('Statuts des propriétés mis à jour avec succès!');
}
}

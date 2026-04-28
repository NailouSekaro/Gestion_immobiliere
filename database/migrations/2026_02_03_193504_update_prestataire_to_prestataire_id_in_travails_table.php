<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('travails', function (Blueprint $table) {

            // 1. Ajouter la nouvelle colonne prestataire_id
            $table->foreignId('prestataire_id')
                ->nullable()
                ->after('prestataire')
                ->constrained('users')
                ->nullOnDelete();
        });

        // 2. (OPTIONNEL) Tu peux migrer les données plus tard si besoin

        Schema::table('travails', function (Blueprint $table) {
            // 3. Supprimer l’ancienne colonne texte
            $table->dropColumn('prestataire');
        });
    }

    public function down()
    {
        Schema::table('travails', function (Blueprint $table) {

            // Recréer l’ancienne colonne
            $table->string('prestataire')->nullable();

            // Supprimer la clé étrangère
            $table->dropForeign(['prestataire_id']);
            $table->dropColumn('prestataire_id');
        });
    }
};


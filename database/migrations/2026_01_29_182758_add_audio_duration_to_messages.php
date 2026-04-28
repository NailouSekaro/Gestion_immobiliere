<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Ajouter la durée pour les messages audio
            $table->integer('audio_duration')->nullable()->after('type')->comment('Durée en secondes');
        });

        // Modifier la colonne type pour accepter 'audio'
        // Note: Si tu as déjà 'text', 'image', 'file', on ajoute 'audio'
        DB::statement("ALTER TABLE messages MODIFY COLUMN type ENUM('text', 'image', 'file', 'audio') DEFAULT 'text'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('audio_duration');
        });

        DB::statement("ALTER TABLE messages MODIFY COLUMN type ENUM('text', 'image', 'file') DEFAULT 'text'");
    }
};

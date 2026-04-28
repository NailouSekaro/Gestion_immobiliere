<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->uuid('uuid')->unique();

        // Relation expéditeur
        $table->foreignId('expediteur_id')->constrained('users')->onDelete('cascade');

        // Relation destinataire
        $table->foreignId('destinataire_id')->constrained('users')->onDelete('cascade');

        // Contenu du message
        $table->text('contenu');
        $table->string('sujet', 255)->nullable();

        // Statut et lecture
        $table->boolean('lu')->default(false);
        $table->timestamp('lu_le')->nullable();

        // Pièces jointes
        $table->string('piece_jointe')->nullable();

        $table->softDeletes();
        $table->timestamps();

        // Index
        $table->index('uuid');
        $table->index('expediteur_id');
        $table->index('destinataire_id');
        $table->index('lu');
        $table->index(['expediteur_id', 'destinataire_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};

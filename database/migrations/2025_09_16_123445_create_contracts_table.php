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
    Schema::create('contracts', function (Blueprint $table) {
        $table->id();
        $table->uuid('uuid')->unique();

        // Relations
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('property_id')->constrained()->onDelete('cascade');

        // Informations du contrat
        $table->string('numero_contrat')->unique();
        $table->date('date_debut');
        $table->date('date_fin');
        $table->integer('duree_mois');
        $table->decimal('loyer_mensuel', 10, 2);
        $table->decimal('caution', 10, 2)->default(0);
        $table->string('devise')->default('XAF');

        // Termes et conditions
        $table->text('termes')->nullable();
        $table->json('clauses_speciales')->nullable();

        // Statut
        $table->enum('statut', ['actif', 'expire', 'resilie', 'avenant'])->default('actif');
        $table->date('date_signature')->nullable();
        $table->date('date_resiliation')->nullable();

        // Fichiers
        $table->string('fichier_pdf')->nullable();
        $table->string('signature_locataire')->nullable();
        $table->string('signature_proprio')->nullable();

        $table->softDeletes();
        $table->timestamps();

        // Index
        $table->index('uuid');
        $table->index('numero_contrat');
        $table->index('statut');
        $table->index(['user_id', 'property_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};

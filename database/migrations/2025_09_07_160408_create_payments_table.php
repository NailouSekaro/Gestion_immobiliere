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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->uuid('uuid')->unique();

        // Relations
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('property_id')->constrained()->onDelete('cascade');

        // Informations de paiement
        $table->string('reference')->unique();
        $table->decimal('montant', 12, 2);
        $table->string('devise')->default('XAF');
        $table->string('mois_paye'); // Format: YYYY-MM
        $table->integer('annee');
        $table->string('periode'); // Ex: "Janvier 2024"

        // Méthode de paiement
        $table->enum('methode', ['mtn_momo', 'orange_money', 'wave', 'feda_pay', 'virement', 'especes', 'autre']);
        $table->string('operateur')->nullable(); // MTN, Orange, etc.
        $table->string('numero_transaction')->nullable();

        // Statut du paiement
        $table->enum('statut', ['en_attente', 'paye', 'echec', 'annule', 'rembourse'])->default('en_attente');
        $table->timestamp('paye_le')->nullable();

        // Dates importantes
        $table->date('date_limite');
        $table->timestamp('date_paiement')->nullable();

        // Informations supplémentaires
        $table->text('notes')->nullable();
        $table->json('metadata')->nullable(); // Pour stocker des infos supplémentaires

        // Fichiers
        $table->string('preuve_paiement')->nullable(); // Reçu, screenshot, etc.

        $table->softDeletes();
        $table->timestamps();

        // Index
        $table->index('uuid');
        $table->index('reference');
        $table->index('statut');
        $table->index('methode');
        $table->index(['user_id', 'property_id']);
        $table->index('mois_paye');
        $table->index('annee');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

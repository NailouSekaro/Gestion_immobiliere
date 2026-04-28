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
    Schema::create('properties', function (Blueprint $table) {
        $table->id();
        $table->uuid('uuid')->unique();

        // Informations de base
        $table->string('nom')->nullable();
        $table->text('adresse');
        $table->string('ville');
        $table->string('pays')->default('Benin');
        $table->string('type')->default('Maison'); // maison, appartement, studio, etc.

        // Caractéristiques
        $table->integer('nombre_pieces');
        $table->integer('surface');
        $table->text('caracteristiques')->nullable(); // JSON ou texte

        // Informations financières
        $table->decimal('loyer_mensuel', 10, 2);
        $table->decimal('caution', 10, 2)->default(0);
        $table->string('devise')->default('XAF');
        $table->date('date_disponibilite');

        // Statut
        $table->enum('statut', ['libre', 'occupé', 'maintenance'])->default('libre');
        $table->text('notes')->nullable();

        // Soft delete et timestamps
        $table->softDeletes();
        $table->timestamps();

        // Index
        $table->index('uuid');
        $table->index('ville');
        $table->index('statut');
        $table->index('type');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

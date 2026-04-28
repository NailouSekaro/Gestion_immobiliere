<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consommation_eaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();

            $table->decimal('index_precedent', 8, 2)->default(0);
            $table->decimal('index_compteur', 8, 2);
            $table->decimal('consommation', 8, 2);

            $table->integer('prix_m3')->default(550);
            $table->decimal('montant', 10, 2);

            $table->date('periode_debut')->nullable();
            $table->date('periode_fin')->nullable();

            $table->enum('statut', ['non_paye', 'paye'])->default('non_paye');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consommation_eaus');
    }
};

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
        Schema::create('cautions', function (Blueprint $table) {
                $table->id();

                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('property_id')->constrained()->cascadeOnDelete();

                $table->integer('caution_chambre')->default(60000);
                $table->integer('caution_eau')->default(0);
                $table->integer('caution_electricite')->default(0);

                $table->integer('total_caution');

                $table->string('methode');
                $table->string('operateur')->nullable();
                $table->string('numero_transaction')->nullable();

                $table->dateTime('date_paiement');
                $table->enum('statut', ['en_attente', 'paye'])->default('paye');

                $table->string('reference')->unique();
                $table->string('verification_token')->nullable();

                $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cautions');
    }
};

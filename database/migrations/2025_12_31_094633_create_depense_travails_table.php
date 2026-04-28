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
        Schema::create('depense_travails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travail_id')->constrained()->cascadeOnDelete();
            $table->string('libelle');
            $table->decimal('montant', 10, 2);
            $table->date('date_depense');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depense_travails');
    }
};

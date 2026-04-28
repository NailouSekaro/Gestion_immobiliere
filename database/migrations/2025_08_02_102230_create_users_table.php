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
        // database/migrations/xxxx_create_users_table.php

Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->string('nom', 100);
    $table->string('prenom', 100);
    $table->string('email')->unique();
    $table->timestamp('email_verifie_le')->nullable();
    $table->string('password');
    $table->string('telephone', 20)->nullable();
    $table->enum('role', [ 'admin', 'locataire', 'prestataire']);
    $table->text('secret_2fa')->nullable();
    $table->text('codes_recuperation_2fa')->nullable();
    $table->timestamp('2fa_confirme_le')->nullable();
    $table->string('photo_profil', 2048)->nullable();
    $table->boolean('est_actif')->default(true);
    $table->timestamp('derniere_connexion')->nullable();
    $table->ipAddress('ip_derniere_connexion')->nullable();
    $table->integer('tentatives_connexion_echouees')->default(0);
    $table->timestamp('verrouille_jusqu')->nullable();
    $table->rememberToken();
    $table->timestamps();
    $table->softDeletes();

    $table->index('email');
    $table->index('uuid');
    $table->index('role');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

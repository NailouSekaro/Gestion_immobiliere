<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            // Ajouter une colonne pour identifier les conversations
            $table->string('conversation_id')->nullable()->after('uuid');
            $table->index('conversation_id');

            // Ajouter un type de message (optionnel)
            $table->enum('type', ['text', 'image', 'file'])->default('text')->after('contenu');

            // Pour le temps réel
            $table->timestamp('delivered_at')->nullable()->after('lu_le');
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['conversation_id', 'type', 'delivered_at']);
        });
    }
};

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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profil_user_id');
            $table->unsignedBigInteger('heure_id');
            $table->unsignedBigInteger('jour_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('statut_id')->default(1);
            $table->foreign('profil_user_id')->references('id')->on('profil_users');
            $table->foreign('heure_id')->references('id')->on('heures');
            $table->foreign('jour_id')->references('id')->on('jours');
            $table->foreign('statut_id')->references('id')->on('statuts');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};

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
        Schema::table('profil_users', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('habilitation_id')->nullable();
            $table->foreign('habilitation_id')->references('id')->on('habilitations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_users', function (Blueprint $table) {
            //
        });
    }
};

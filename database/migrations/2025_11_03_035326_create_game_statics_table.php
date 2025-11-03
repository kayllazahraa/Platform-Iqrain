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
        Schema::create('game_statics', function (Blueprint $table) {
            $table->id('game_static_id');
            $table->unsignedBigInteger('tingkatan_id');
            $table->unsignedBigInteger('jenis_game_id');
            $table->string('nama_game', 100);
            $table->longText('data_json');
            $table->timestamps();

            $table->foreign('tingkatan_id')->references('tingkatan_id')->on('tingkatan_iqras')->onDelete('cascade');
            $table->foreign('jenis_game_id')->references('jenis_game_id')->on('jenis_games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_statics');
    }
};

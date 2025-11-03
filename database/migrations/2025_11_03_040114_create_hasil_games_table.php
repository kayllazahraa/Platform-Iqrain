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
        Schema::create('hasil_games', function (Blueprint $table) {
            $table->id('hasil_game_id');
            $table->unsignedBigInteger('murid_id');
            $table->unsignedBigInteger('jenis_game_id');
            $table->unsignedBigInteger('soal_id')->nullable();
            $table->unsignedBigInteger('game_static_id')->nullable();
            $table->integer('skor');
            $table->integer('total_poin');
            $table->datetime('dimainkan_at');
            $table->timestamps();

            $table->foreign('murid_id')->references('murid_id')->on('murids')->onDelete('cascade');
            $table->foreign('jenis_game_id')->references('jenis_game_id')->on('jenis_games')->onDelete('cascade');
            $table->foreign('soal_id')->references('soal_id')->on('soal_drag_drops')->onDelete('set null');
            $table->foreign('game_static_id')->references('game_static_id')->on('game_statics')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_games');
    }
};

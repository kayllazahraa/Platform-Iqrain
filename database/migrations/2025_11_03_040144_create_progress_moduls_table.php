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
        Schema::create('progress_moduls', function (Blueprint $table) {
            $table->id('progress_modul_id');
            $table->unsignedBigInteger('murid_id');
            $table->unsignedBigInteger('modul_id');
            $table->enum('status', ['belum_dibuka', 'selesai'])->default('belum_dibuka');
            $table->datetime('tanggal_mulai')->nullable();
            $table->datetime('tanggal_selesai')->nullable();
            $table->timestamps();

            $table->foreign('murid_id')->references('murid_id')->on('murids')->onDelete('cascade');
            $table->foreign('modul_id')->references('modul_id')->on('moduls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_moduls');
    }
};

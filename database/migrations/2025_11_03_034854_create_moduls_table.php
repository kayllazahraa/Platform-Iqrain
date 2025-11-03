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
        Schema::create('moduls', function (Blueprint $table) {
            $table->id('modul_id');
            $table->unsignedBigInteger('materi_id');
            $table->string('judul_modul', 100);
            $table->text('konten_teks')->nullable();
            $table->string('gambar_path')->nullable();
            $table->string('teks_latin')->nullable();
            $table->integer('urutan');
            $table->timestamps();

            $table->foreign('materi_id')->references('materi_id')->on('materi_pembelajarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moduls');
    }
};

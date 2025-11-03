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
        Schema::create('materi_pembelajarans', function (Blueprint $table) {
            $table->id('materi_id');
            $table->unsignedBigInteger('tingkatan_id');
            $table->string('judul_materi', 100);
            $table->text('deskripsi')->nullable();
            $table->integer('urutan');
            $table->timestamps();

            $table->foreign('tingkatan_id')->references('tingkatan_id')->on('tingkatan_iqras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_pembelajarans');
    }
};

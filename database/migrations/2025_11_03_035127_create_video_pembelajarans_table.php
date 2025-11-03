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
        Schema::create('video_pembelajarans', function (Blueprint $table) {
            $table->id('video_id');
            $table->unsignedBigInteger('tingkatan_id');
            $table->string('judul_video', 100);
            $table->string('video_path');
            $table->string('subtitle_path')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('tingkatan_id')->references('tingkatan_id')->on('tingkatan_iqras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_pembelajarans');
    }
};

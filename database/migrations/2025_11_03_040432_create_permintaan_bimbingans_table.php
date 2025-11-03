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
        Schema::create('permintaan_bimbingans', function (Blueprint $table) {
            $table->id('permintaan_id');
            $table->unsignedBigInteger('murid_id');
            $table->unsignedBigInteger('mentor_id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->datetime('tanggal_permintaan');
            $table->datetime('tanggal_respons')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('murid_id')->references('murid_id')->on('murids')->onDelete('cascade');
            $table->foreign('mentor_id')->references('mentor_id')->on('mentors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_bimbingans');
    }
};

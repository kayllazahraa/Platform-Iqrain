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
        Schema::create('soal_drag_drops', function (Blueprint $table) {
            $table->id('soal_id');
            $table->unsignedBigInteger('tingkatan_id');
            $table->unsignedBigInteger('mentor_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->text('pertanyaan');
            $table->string('opsi_a');
            $table->string('opsi_b');
            $table->string('opsi_c');
            $table->string('opsi_d');
            $table->char('jawaban_benar', 1);
            $table->enum('status_approval', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('tingkatan_id')->references('tingkatan_id')->on('tingkatan_iqras')->onDelete('cascade');
            $table->foreign('mentor_id')->references('mentor_id')->on('mentors')->onDelete('set null');
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_drag_drops');
    }
};

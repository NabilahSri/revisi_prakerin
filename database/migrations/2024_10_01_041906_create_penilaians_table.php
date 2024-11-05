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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_industri');
            $table->unsignedBigInteger('id_kategori_penilaian');
            $table->string('nilai');
            $table->string('saran')->nullable();
            $table->foreign('id_siswa')->references('id')->on('siswas')->onDelete('no action')->onUpdate('no action');
            $table->foreign('id_industri')->references('id')->on('industris')->onDelete('no action')->onUpdate('no action');
            $table->foreign('id_kategori_penilaian')->references('id')->on('kategori_penilaians')->onDelete('no action')->onUpdate('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};

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
        Schema::create('token_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->dateTime('kadaluarsa_pada');
            $table->unsignedBigInteger('id_industri');
            $table->timestamps();
            $table->foreign('id_industri')->references('id')->on('industris')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_masuks');
    }
};
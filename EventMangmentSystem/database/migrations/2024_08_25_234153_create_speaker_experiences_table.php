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
        Schema::create('speaker_experiences', function (Blueprint $table) {
            $table->id('speaker_experience_id');
            $table->string('speaker_experience_name');
            $table->integer('speaker_experience_year');
            $table->unsignedBigInteger('speaker_id');
            $table->foreign('speaker_id')->references('speaker_id')->on('speakers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speaker_experiences');
    }
};

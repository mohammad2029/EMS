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
        Schema::create('organization_speakers', function (Blueprint $table) {
            $table->id('organization_speaker_id');
            $table->date('speaker_start_date');
            $table->unsignedBigInteger('speaker_id');
            $table->foreign('speaker_id')->references('speaker_id')->on('speakers')->onDelete('cascade');
            $table->unsignedBigInteger('organization_id');
            $table->foreign('organization_id')->references('organization_id')->on('organizations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_speakers');
    }
};

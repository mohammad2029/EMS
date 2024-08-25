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
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('event_name');
            $table->string('event_description');
            $table->string('countrey');
            $table->string('state');
            $table->string('street');
            $table->string('place');
            $table->enum('event_type',['cultural','sport','technical','scientific','artistic','entertaining','commercial']);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('tickets_number');
            $table->double('ticket_price');
            $table->boolean('is_done')->default(0);
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('organization_id');
            $table->foreign('organization_id')->references('organization_id')->on('organizations')->onDelete('cascade');
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('doctor_id')->unsigned();
            $table->bigInteger('availability_id')->unsigned();
            $table->date('date_schedule');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('service');
            $table->string('status')->default('pending');
            $table->text('feedback')->nullable();
            $table->text('reason')->nullable();
            $table->json('covidForm')->nullable();
            $table->json('mqForm')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('availability_id')->references('id')->on('doctor_availabilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

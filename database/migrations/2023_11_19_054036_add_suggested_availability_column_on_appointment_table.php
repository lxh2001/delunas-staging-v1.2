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
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('suggested_availability')->nullable()->after('reason');
            $table->foreign('suggested_availability')->references('id')->on('doctor_availabilities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
              $table->dropForeign(['suggested_availability']);
              $table->dropColumn('suggested_availability');
        });
    }
};

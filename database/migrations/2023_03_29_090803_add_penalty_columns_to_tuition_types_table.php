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
        Schema::table('tuition_types', function (Blueprint $table) {
            $table->boolean('generatable')->nullable()->default(false)->change();
            $table->after('generatable', function (Blueprint $table) {
                $table->unsignedBigInteger('penalty_price')->default(0);
                $table->string('penalty_dates', 100)->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuition_types', function (Blueprint $table) {
            $table->boolean('generatable')->nullable()->change();
            $table->dropColumn(['penalty_price', 'penalty_dates']);
        });
    }
};

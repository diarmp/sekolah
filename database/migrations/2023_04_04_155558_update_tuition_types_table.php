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
            $table->string('generatable')->nullable()->renameTo('recurring')->change();

            $table->string('requested_by')->nullable();
            $table->string('approved_by')->nullable();

            $table->dropColumn('penalty_price');
            $table->dropColumn('penalty_dates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuition_types', function (Blueprint $table) {
            $table->string('recurring')->nullable()->renameTo('generatable')->change();

            $table->dropColumn('requested_by');
            $table->dropColumn('approved_by');

            $table->unsignedBigInteger('penalty_price')->default(0);
            $table->string('penalty_dates', 100)->nullable();
        });
    }
};

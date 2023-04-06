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
            //
            $table->dropColumn('requested_by');
            $table->dropColumn('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuition_types', function (Blueprint $table) {
            //
            $table->string('requested_by')->nullable();
            $table->string('approved_by')->nullable();
        });
    }
};

<?php

use App\Models\School;
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
        Schema::table('schools', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('type', 20)->number_format;
                $table->foreignIdFor(School::class)->nullable()->constrained()->nullOnDelete();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeignIdFor(School::class);
            $table->dropColumn(['type', 'school_id']);
        });
    }
};

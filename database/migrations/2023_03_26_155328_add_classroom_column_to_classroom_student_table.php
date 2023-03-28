<?php

use App\Models\Classroom;
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
        Schema::table('classroom_student', function (Blueprint $table) {
            $table->foreignIdFor(Classroom::class)->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classroom_student', function (Blueprint $table) {
            $table->dropForeignIdFor(Classroom::class);
            $table->dropColumn('classroom_id');
        });
    }
};

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
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('father_work');
            $table->dropColumn('mother_work');
            $table->dropColumn('guardian_work');
            
            $table->dropForeign('students_academic_year_id_foreign');
            $table->dropColumn('academic_year_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('father_work')->nullable();
            $table->string('mother_work')->nullable();
            $table->string('guardian_work')->nullable();
            $table->foreignIdFor(AcademicYear::class)->nullable()->comment('First Academic Year')->constrained()->nullOnDelete();
        });
    }
};

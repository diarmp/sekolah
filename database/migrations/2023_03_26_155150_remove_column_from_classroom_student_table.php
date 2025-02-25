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
        Schema::table('classroom_student', function (Blueprint $table) {
            $table->dropForeign('classroom_students_school_id_foreign');
            $table->dropColumn('school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classroom_student', function (Blueprint $table) {
            $table->foreignIdFor(School::class)->nullable()->after('id')->constrained()->nullOnDelete()->change();
        });
    }
};

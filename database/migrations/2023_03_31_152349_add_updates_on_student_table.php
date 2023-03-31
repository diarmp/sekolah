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
            $table->string('no_kartu_keluarga', 25)->nullable()->after('phone_number');

            $table->string('father_phone_number')->nullable()->after('father_name');
            $table->text('father_address')->nullable()->after('father_name');
            $table->dropColumn('father_education');
            $table->dropColumn('father_income');
            $table->dropColumn('father_dob');

            $table->string('mother_phone_number')->nullable()->after('mother_name');
            $table->text('mother_address')->nullable()->after('mother_name');
            $table->dropColumn('mother_education');
            $table->dropColumn('mother_income');
            $table->dropColumn('mother_dob');

            $table->string('guardian_phone_number')->nullable()->after('guardian_name');
            $table->text('guardian_address')->nullable()->after('guardian_name');
            $table->dropColumn('guardian_education');
            $table->dropColumn('guardian_income');
            $table->dropColumn('guardian_dob');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('no_kartu_keluarga');

            $table->dropColumn('father_phone_number');
            $table->dropColumn('father_address');
            $table->string('father_education');
            $table->string('father_income');
            $table->date('father_dob');

            $table->dropColumn('mother_phone_number');
            $table->dropColumn('mother_address');
            $table->string('mother_education');
            $table->string('mother_income');
            $table->date('mother_dob');

            $table->dropColumn('guardian_phone_number');
            $table->dropColumn('guardian_address');
            $table->string('guardian_education');
            $table->string('guardian_income');
            $table->date('guardian_dob');
        });
    }
};

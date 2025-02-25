<?php

use App\Models\User;
use App\Models\School;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(School::class)->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('gender', 1)->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('religion', 10)->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('nisn', 10)->nullable();
            $table->string('father_name')->nullable();
            $table->date('father_dob')->nullable();
            $table->string('father_work')->nullable();
            $table->string('father_education', 50)->nullable();
            $table->string('father_income', 50)->nullable();
            $table->string('mother_name')->nullable();
            $table->date('mother_dob')->nullable();
            $table->string('mother_work')->nullable();
            $table->string('mother_education', 50)->nullable();
            $table->string('mother_income', 50)->nullable();
            $table->string('guardian_name')->nullable();
            $table->date('guardian_dob')->nullable();
            $table->string('guardian_work')->nullable();
            $table->string('guardian_education', 50)->nullable();
            $table->string('guardian_income', 50)->nullable();
            $table->foreignIdFor(AcademicYear::class)->nullable()->comment('First Academic Year')->constrained()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};

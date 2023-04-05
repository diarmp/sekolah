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
        Schema::table('academic_years', function (Blueprint $table) {


            $table->string('name')->nullable()->renameTo('academic_year_name')->change();
            $table->after('academic_year_name', function ($table) {
                $table->enum('status_years', ['registration', 'started', 'closed'])->default('closed')->change();
                $table->date('year_start')->nullable();
                $table->date('year_end')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropColumn(['year_end', 'year_start']);
            $table->string('status_years')->nullable()->change();
            $table->string('academic_year_name')->nullable()->renameTo('name')->change();

            // $table->string('name')->nullable();
            // $table->string('status_years')->nullable();
        });
    }
};

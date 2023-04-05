<?php

use App\Models\School;
use App\Models\User;
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

            $table->dropForeignIdFor(User::class, 'staff_id');
            $table->dropColumn(['type', 'staff_id']);

            $table->renameColumn('name', 'school_name');
            $table->after('id', function ($table) {
                $table->foreignIdFor(User::class, 'owner_id')->nullable();
                $table->enum('grade', ["TK", "SD", "SMP", "SMA", "SMK"])->nullable();
                $table->text('address')->nullable();
                $table->string('city')->nullable();
                $table->string('province')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('postal_code', 20)->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
        });
    }
};

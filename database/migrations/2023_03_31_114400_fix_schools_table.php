<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['type']);
            $table->string('name')->nullable()->renameTo('school_name')->change();
            $table->after('school_id', function ($table) {
                $table->enum('grade', ['TK', 'SD','SMP',"SMA","SMK"]);
                $table->text("address")->nullable();
                $table->string("city")->nullable();
                $table->string("province")->nullable();
                $table->string("phone")->nullable();
                $table->string("email")->nullable();
                $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('type', 20)->number_format;
            });
            $table->dropColumn(['grade','alamat','city','province','telp','email']);
            $table->dropForeign(['owner_id']);
            $table->renameColumn('school_name', 'name');
        });
    }
};

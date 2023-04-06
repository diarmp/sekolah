<?php

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
        Schema::table('tuitions', function (Blueprint $table) {
            //
            $table->foreignIdFor(User::class, 'request_by')->nullable();
            $table->foreignIdFor(User::class, 'approval_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuitions', function (Blueprint $table) {
            //
            $table->dropColumn([
                'request_by',
                'approval_by'
            ]);
        });
    }
};

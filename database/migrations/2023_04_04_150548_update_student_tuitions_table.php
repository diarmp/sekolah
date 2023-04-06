<?php

use App\Models\PaymentType;
use App\Models\TuitionType;
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
        Schema::table('student_tuitions', function (Blueprint $table) {
            $table->date('period')->nullable()->after('note');
            $table->string('bill_number')->nullable()->after('period');
            $table->double('grand_total')->nullable()->after('bill_number');
            $table->string('status')->default('pending')->after('grand_total');
            $table->boolean('is_sent')->default(false)->after('status');

            $table->dropColumn('price');
            $table->dropColumn('penalty');

            $table->dropForeign('student_tuitions_tuition_type_id_foreign');
            $table->dropColumn('tuition_type_id');

            $table->foreignIdFor(PaymentType::class)->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_tuitions', function (Blueprint $table) {
            $table->double('price')->nullable();
            $table->boolean('penalty')->default(false)->after('note');

            $table->foreignIdFor(TuitionType::class)->nullable()->constrained()->nullOnDelete();

            $table->dropForeign('student_tuitions_payment_type_id_foreign');
            $table->dropColumn('tuition_type_id');

            $table->dropColumn('period');
            $table->dropColumn('bill_number');
            $table->dropColumn('grand_total');
            $table->dropColumn('status');
            $table->dropColumn('is_sent');
        });
    }
};

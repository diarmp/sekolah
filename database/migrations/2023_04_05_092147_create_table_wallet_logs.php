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
        Schema::create('table_wallet_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('cashflow_type', ['in', 'out'])->nullable();
            $table->double('amount')->nullable();
            $table->text('note')->nullable();
            $table->bigInteger('wallet_id')->unsigned()->nullable();
            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_wallet_logs');
    }
};

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
        Schema::create('table_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->string('item_name')->nullable();
            $table->double('price')->nullable();
            $table->bigInteger('wallet_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_invoice_details');
    }
};

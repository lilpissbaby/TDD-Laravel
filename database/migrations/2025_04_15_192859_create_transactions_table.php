<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('from_account_id');
        $table->unsignedBigInteger('to_account_id');
        $table->decimal('amount', 10, 2);
        $table->timestamps();

        $table->foreign('from_account_id')->references('id')->on('accounts');
        $table->foreign('to_account_id')->references('id')->on('accounts');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

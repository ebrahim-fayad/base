<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('wallet_id')->unsigned()->index();
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');

            $table->integer('type')->default(0);
            $table->decimal('amount', 15, 2)->default(0);

            $table->integer('transactionable_id')->unsigned()->nullable();
            $table->string('transactionable_type', 50)->nullable();

            $table->string('transaction_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
};

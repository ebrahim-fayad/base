<?php

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_num')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->double('price')->default(0);
            $table->double('vat_amount')->default(0);
            $table->double('total_price')->default(0);
            $table->double('admin_commission')->default(0);
            $table->double('payment_amount')->default(0);
            $table->tinyInteger('status')->default(OrderStatusEnum::NEW->value);
            $table->tinyInteger('payment_method')->default(PaymentMethodEnum::WALLET->value);
            $table->string('receiver_name')->nullable();
            $table->string('country_code')->default('966');
            $table->string('phone')->nullable();
            $table->dateTime('receiver_date_time')->nullable();
            $table->string('sender_name')->nullable();
            $table->text('message')->nullable();
            $table->datetime('auto_cancelled_at')->nullable();
            $table->double('net_provider_amount')->default(0);
            $table->boolean('is_settled')->default(false);
            $table->boolean('is_settled_vat')->default(false);
            $table->string('job_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

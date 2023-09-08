<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('address_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_status_id')->constrained()->cascadeOnDelete();
            $table->double('coupon_price', 8, 4)->default(0.0);
            $table->foreignId('payment_type_id')->constrained('payment_types')->cascadeOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->cascadeOnDelete();
            $table->double('subtotal', 8, 4);
            $table->double('discount', 8, 4);
            $table->double('grand_total', 8, 4);
            $table->text('notes');
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
        Schema::dropIfExists('orders');
    }
}

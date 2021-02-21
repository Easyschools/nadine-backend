<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->boolean('is_percentage')->default(0);
            $table->double('discount', 8, 2)->default(0);
            $table->integer('max_usage_per_order')->default(1);
            $table->integer('max_usage_per_user')->default(1);
            $table->double('min_total', 8, 2)->default(0);
            $table->string('type_ar');
            $table->string('type_en');
            $table->enum('model_type', ['Product', 'Tag', 'Category']);
            $table->string('model_id');
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
        Schema::dropIfExists('coupons');
    }
}

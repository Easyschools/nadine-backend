<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeGrandtotalToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            \Illuminate\Support\Facades\DB::statement('alter table orders modify grand_total DOUBLE(15,2) DEFAULT 0');
            \Illuminate\Support\Facades\DB::statement('alter table orders modify shipping_price DOUBLE(15,2) DEFAULT 0');
            \Illuminate\Support\Facades\DB::statement('alter table orders modify coupon_price DOUBLE(15,2) DEFAULT 0');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}

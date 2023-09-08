<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditContactAddressLongitude extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_address', function (Blueprint $table) {
            //
            $table->decimal('latitude',10,8)->change();
            $table->decimal('longitude',11,8)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_address', function (Blueprint $table) {
            //
        });
    }
}

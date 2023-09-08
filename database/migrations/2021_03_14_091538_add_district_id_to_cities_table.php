<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistrictIdToCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {

            $table->unsignedBigInteger('district_id')->nullable()->after('address');
            $table->foreign('district_id')->references('id')
                ->on('districts')
                ->cascadeOnDelete();

            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            //
        });
    }
}

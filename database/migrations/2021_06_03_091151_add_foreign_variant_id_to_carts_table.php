<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignVariantIdToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            //
            // $table->dropForeign('carts_variant_id_foreign');
            $table->dropForeign(['variant_id']);
            $table->dropColumn('variant_id');
        });
        Schema::table('carts', function (Blueprint $table) {
            //
            $table->foreignId('variant_id')->after('quantity')->constrained('variants')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            //
        });
    }
}

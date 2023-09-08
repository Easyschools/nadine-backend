<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForignVariantIdToVariantImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variant_images', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('variant_images', 'variant_id')) {
                $table->foreignId('variant_id')->nullable()->constrained('variants')
                    ->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('variant_images', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('high_jewellery_collections', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
           $table->string('title');
           $table->string('image');
           $table->text('description');
           $table->text('design_target_desc');
           $table->string('design_target_img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('high_jewellery_collections');
    }
};

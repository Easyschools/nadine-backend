<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->double('star','8','2');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('title')->nullable();
            $table->text('comment')->nullable();
//            $table->unsignedBigInteger('user_id')->nullable();
//            $table->foreign('user_id')
//                ->references('id')->on('users')
//                ->cascadeOnDelete();
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
        Schema::dropIfExists('reviews');
    }
}

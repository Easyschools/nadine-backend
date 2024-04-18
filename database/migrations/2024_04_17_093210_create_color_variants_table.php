3<?php

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
            Schema::create('color_variants', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('color_id');
                $table->foreign('color_id')
                    ->references('id')
                    ->on('colors')->cascadeOnDelete();
                $table->unsignedBigInteger('variant_id');
                $table->foreign('variant_id')
                    ->references('id')
                    ->on('variants')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('color_variants');
        }
    };

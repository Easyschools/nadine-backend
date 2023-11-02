<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')
                ->after('name_ar');
        });
        DB::statement("UPDATE categories SET slug = CONCAT(LOWER(REPLACE(name_en, ' ', '-')))");
        Schema::table('categories', function (Blueprint $table) {
            $table->unique('slug');
        });


        Schema::table('tags', function (Blueprint $table) {
            $table->string('slug')
                ->after('name_ar');
        });
        DB::statement("UPDATE tags SET slug = CONCAT(LOWER(REPLACE(name_en, ' ', '-')))");
        Schema::table('tags', function (Blueprint $table) {
            $table->unique('slug');
        });


        Schema::table('collections', function (Blueprint $table) {
            $table->string('slug')
                ->after('name_ar');
        });
        DB::statement("UPDATE collections SET slug = CONCAT(LOWER(REPLACE(name_en, ' ', '-')))");
        Schema::table('collections', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};

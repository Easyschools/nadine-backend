<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Order\Coupon::class, function (Faker $faker) {
    return [
        'code' =>(string)$faker->year($max = 'now')     ,
        'is_percentage' => $faker->boolean,
        'discount' => 1,
        'model_type' => 'Product',
        'model_id' => 1,
        'type_ar' => 'مستيعد',
        'type_en' => 'excluded',
        'min_total' => '1',
//        'expire_at' => \Carbon\Carbon::now()->addDays(rand(1,4))->format('Y-m-d H:i:s'),
        ];
});

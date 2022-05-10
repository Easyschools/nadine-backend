<?php

namespace App\Http\Controllers\Api\Product;


use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

use MOIREI\GoogleMerchantApi\Facades\ProductApi;
use MOIREI\GoogleMerchantApi\Contents\Product\Product as GMProduct;
// use Joseaneto\GoogleMerchantApi\Facades\ProductApi;

class ProductApiGoogleController extends Controller
{
    public function insert()
    {
        $model = Product::find(10);
        $product = (new GMProduct)->with($model);

        ProductApi::insert($product)->catch(function ($e) {
            // always catch exceptions
        });
    }

    public function get()
    {
        $model = Product::find(9);
        $product = (new GMProduct)->with($model);
        ProductApi::list()->then(function ($product) {
            //
        });
    }
}

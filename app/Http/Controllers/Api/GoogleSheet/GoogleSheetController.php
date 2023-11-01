<?php

namespace App\Http\Controllers\Api\GoogleSheet;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class GoogleSheetController extends Controller
{
    public function deleteSheet()
    {
        $spreadsheetId = '1clgd9IeNPM1Gt0yfaPrDtyx0x2HHOtl2Pz8QXcbLJY4';
        $sheetId = 0;
        // $range = 'A1';
        $sheetName = 'sheet1';
        Sheets::spreadsheet($spreadsheetId)
            ->sheet($sheetName)
            ->clear();
    }

    public function addHeaders()
    {
        $spreadsheetId = '1clgd9IeNPM1Gt0yfaPrDtyx0x2HHOtl2Pz8QXcbLJY4';
        $sheetId = 0;
        // $range = 'A1';
        $sheetName = 'sheet1';
        Sheets::spreadsheet($spreadsheetId)
            ->sheet('sheet1')
            ->append([['id', 'item_group_id', 'title', 'description', 'price', 'link', 'image_link', 'sale_price', 'brand', 'availability', 'condition', 'fb_product_category', 'google_product_category']]);
    }

    public function updateSheet()
    {
        // $currentTime = date("Y-m-d H:i:s"); // Format: YYYY-MM-DD HH:MM:SS
        // return $currentTime;

        $spreadsheetId = '1clgd9IeNPM1Gt0yfaPrDtyx0x2HHOtl2Pz8QXcbLJY4';
        $sheetId = 0;
        // $range = 'A1';
        $sheetName = 'sheet1';

        //add new sheet
        //  Sheets::spreadsheet($spreadsheetId)
        //     ->addSheet('New');






        //add header 
        //   $this->addHeaders();

        //get data from db
        $products_count = Product::with('tag')->count();
        $counts = $products_count / 60;
        $roundedNumber = ceil($counts);

        // $products = Product::with('tag')->skip(10)->take(10)->get();
        // $data = [
        //     'products' => $products,

        //     // Add more data as needed
        // ];

        // Call the endpoint in Controller2
        // return $response = app(HandlingController::class)->handling(new Request($data));

        for ($i = 0; $i <= $roundedNumber;) {
            $products = Product::with('tag')->skip($i * 60)->take(60)->get();
            $data = [
                'products' => $products,

                // Add more data as needed
            ];

            // Call the endpoint in Controller2
            $response = app(HandlingController::class)->handling(new Request($data));
            if ($response == "yes") {
                $i++;
            }
        }



        // return $response;

        //add data to sheet   

        // foreach ($products as $product) {
        //     Sheets::spreadsheet($spreadsheetId)
        //         ->sheet('sheet1')
        //         ->append([
        //             [
        //                 'id' => $product->id,
        //                 // 'item_group_id',
        //                 'title' => $product->name_ar,
        //                 'description' => $product->description_ar,
        //                 'price' => $product->price,
        //                 // 'link', 
        //                 'image_link' => $product->image,
        //                 'sale_price' => $product->price_after_discount,
        //                 'brand' => 'Unit Art',
        //                 // 'availability', 
        //                 // 'condition', 
        //                 'fb_product_category' => $product->category->name_en,
        //                 'google_product_category' => $product->tag->name_en
        //             ]
        //         ]);
        // }
    }
}

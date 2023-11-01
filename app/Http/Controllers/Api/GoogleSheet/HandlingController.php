<?php

namespace App\Http\Controllers\Api\GoogleSheet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;


class HandlingController extends Controller
{
    public function handling(Request $request){
        // Log::info($request->products['id']);
        // $ids =[];
        // foreach($request['products'] as $pro){
        //     $ids[] = $pro['id'];
        // }
        // Log::info($ids);
        // return $ids;
        // return $request['products'][]['id'];

        $spreadsheetId = '1clgd9IeNPM1Gt0yfaPrDtyx0x2HHOtl2Pz8QXcbLJY4';
        $sheetId = 0;
        // $range = 'A1';
        $sheetName = 'sheet1';

         foreach ($request['products'] as $product) {
            Sheets::spreadsheet($spreadsheetId)
                ->sheet('sheet1')
                ->append([
                    [
                        'id' => $product->id,
                        // 'item_group_id',
                        'title' => $product->name_ar,
                        'description' => $product->description_ar,
                        'price' => $product->price,
                        // 'link', 
                        'image_link' => $product->image,
                        'sale_price' => $product->price_after_discount,
                        'brand' => 'Unit Art',
                        // 'availability', 
                        // 'condition', 
                        'fb_product_category' => $product->category->name_en,
                        'google_product_category' => $product->tag->name_en
                    ]
                ]);
        }
        return "yes";
    }
}

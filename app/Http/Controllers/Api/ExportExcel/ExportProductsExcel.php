<?php

namespace App\Http\Controllers\Api\ExportExcel;

use App\Exports\ProductsExport;
use App\Exports\ProductsExportAr;
use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ExportProductsExcel extends Controller
{
    public function export(){
        //  $products = Product::with('tag', 'variants')->first();
        //  return $products->variants['id'];
        $fileName = 'unitArtDataEn.csv'; // Specify the desired file name
        $filePath = 'exports/unitArtDataEn.csv'; // Specify the file path

        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
            info('yes');
            $path = Excel::store(new ProductsExport, 'exports/' . $fileName, 'public');
        } else {
            $path = Excel::store(new ProductsExport, 'exports/' . $fileName, 'public');
        }


        $fileName = 'unitArtDataAr.csv'; // Specify the desired file name
        $filePath = 'exports/unitArtDataAr.csv'; // Specify the file path

        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
            info('yes');
            $path = Excel::store(new ProductsExportAr, 'exports/' . $fileName, 'public');
        } else {
            $path = Excel::store(new ProductsExportAr, 'exports/' . $fileName, 'public');
        }
    }
}

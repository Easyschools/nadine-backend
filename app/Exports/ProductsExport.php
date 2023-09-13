<?php

namespace App\Exports;

use App\Models\Product\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    public function view(): View
    {
        return view('exports.products', [
            'products' => Product::select([
                'id',
                'name_ar',
                'name_en',
                'description_ar',
                'description_en',
                'price',
                'price_after_discount',
                'sku',
                'collection_id',
                'material_id',
                'tag_id',
            ])
                ->with([
                    'collection:id,name_en',
                    'material:id,name_en',
                    'tag:id,name_en',
                    'variants:id,dimension_id,color_id,product_id,additional_price',
                    'variants.color:id,name_en,name_ar,image',
                    'variants.dimension:id,dimension',
                ])
                ->get()
        ]);
    }
}

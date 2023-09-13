<?php

namespace App\Imports;

use App\Models\Product\Product;
use App\Models\Division\Tag;
use App\Models\Feature\Collection;
use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Models\Option\Material;
use App\Models\Product\Variant;
use Illuminate\Support\Collection as ExcelCollection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Traits\HelperFunctions;

class ProductsImport implements ToCollection
{
    public function collection(ExcelCollection $rows)
    {
        $first = true;
        foreach ($rows as $row) {
            // to skip the first row of headings
            if ($first) {
                $first = false;
                continue;
            }

            $product = Product::where('id', $row[0])->first();
            if (!($product->name_en == $row[2] && $product->sku == $row[7])) {
                $slug = HelperFunctions::makeSlug($row[2]) . '-' . HelperFunctions::makeSlug($row[7]);
            }
            $product->update([
                'name_ar' => $row[1],
                'name_en' => $row[2],
                'slug' => $slug ?? $product->slug,
                'description_ar' => $row[3],
                'description_en' => $row[4],
                'price' => $row[5],
                'price_after_discount' => $row[6],
                'sku' => $row[7],
                'collection_id' => Collection::where('name_en', $row[8])->first()?->id,
                'material_id' => Material::where('name_en', $row[9])->first()?->id,
                'tag_id' => Tag::where('name_en', $row[10])->first()?->id,
            ]);

            $variants = [];
            $oldVariants = $product->variants()->select('id', 'color_id', 'dimension_id', 'additional_price')->get();
            for ($i = 11; isset($row[$i]); $i++) {
                $variant = explode(',', $row[$i]); // name_en, name_ar, image, additional_price, dimension
                $color = Color::firstOrCreate([
                    'name_en' => trim($variant[0]),
                ], [
                    'name_ar' => trim($variant[1]),
                    'image' => isset($variant[2]) ? trim($variant[2]) : null,
                ]);

                $dimension = Dimension::firstOrCreate([
                    'dimension' => trim($variant[count($variant) - 1]),
                ]);

                $variants[] = [
                    'color_id' => $color->id,
                    'dimension_id' => $dimension->id,
                    'additional_price' => $variant[3],
                ];
            }

            // dd($oldVariants, $variants);
            foreach ($oldVariants as $oldVariant) {
                $isExist = false;
                foreach ($variants as $key => $variant) {
                    if ($oldVariant->color_id == $variant['color_id'] && $oldVariant->dimension_id == $variant['dimension_id']) {
                        $isExist = true;
                        if ($oldVariant->additional_price != $variant['additional_price']) {
                            $oldVariant->update(['additional_price' => $variant['additional_price']]);
                        }
                        unset($variants[$key]);
                        break;
                    }
                }

                if (!$isExist) {
                    $oldVariant->delete();
                }
            }

            foreach ($variants as $variant) {
                $product->variants()->create($variant);
            }
        }
    }
}

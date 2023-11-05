<?php

namespace App\Exports;

use App\Models\Product\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductsExport implements FromArray, WithHeadings
{
    use Exportable;
    public function array(): array
    {
        $data = [];
        $products = Product::with('tag', 'variants')->get();
        $groupCounter = [];

        foreach ($products as $product) {
            $colorId = null;
            $dimensionId = null;

            foreach ($product->variants as $var) {
                $colorId = $var->color_id;
                $dimensionId = $var->dimention_id;
                // Use the first color_id and dimention_id encountered
                break;
            }

            // Create a unique group identifier based on color_id and dimension_id
            $groupIdentifier = "{$colorId}_{$dimensionId}";

            // Check if we've encountered this group identifier before
            if (!isset($groupCounter[$groupIdentifier])) {
                // If not, initialize the counter to 1
                $groupCounter[$groupIdentifier] = count($groupCounter) + 1;
            }

            $groupNumber = $groupCounter[$groupIdentifier];

            $data[] = [
                'id' => $product->id,
                'item_group_id' => "group {$groupNumber}",
                'title' => $product->name_en,
                'description' => $product->description_en,
                'price' => $product->price,
                'link' => 'https://unitart.net/product/' . $product->slug,
                'image_link' => $product->image,
                'sale_price' => $product->price_after_discount,
                'brand' => 'unit art',
                'availability' => 'in stock',
                'condition' => 'new',
                'fb_product_category' => $product->tag->name_en,
                'google_product_category' => $product->tag->name_en,
                'currency' => 'EGP',
            ];
        }

        usort($data, function ($a, $b) {
            $pattern = '/\d+/'; // Regular expression to match digits
            preg_match($pattern, $a['item_group_id'], $matchesA);
            preg_match($pattern, $b['item_group_id'], $matchesB);

            $numberA = (int)$matchesA[0];
            $numberB = (int)$matchesB[0];

            return $numberA - $numberB;
        });

        return $data;
    }

    public function headings(): array
    {
        // Define the column headings for the Excel file
        return [
            'id',
            'item_group_id',
            'title',
            'description',
            'price',
            'link',
            'image_link',
            'sale_price',
            'brand',
            'availability',
            'condition',
            'fb_product_category',
            'google_product_category',
            'currency'
        ];
    }
}

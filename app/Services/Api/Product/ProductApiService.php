<?php

namespace App\Services\Api\Product;

use App\Models\Division\Tag;
use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Models\Product\Product;
use App\Models\Product\Variant;
use App\Models\Product\VariantImage;
use App\Repositories\AppRepository;
use App\Traits\HelperFunctions;
use Illuminate\Support\Facades\DB;


class ProductApiService extends AppRepository
{

    private $variantRepo;
    private $append = 0;

    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->variantRepo = new AppRepository(new Variant());
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->filter($request);

        $this->setRelations([
            'variants' => function ($variant) {
                $variant->select('product_id', 'color_id', 'dimension_id', 'id')->with(
                    'Color:id,name_en,name_ar,code,image',
                    'Dimension:id,dimension',
                    'images:id,variant_id,image'
                );
            },
            'tag:id,name_en,name_ar,category_id'
        ]);


        $this->setAppends([
            'currency',
            'type',
            'tags',
            'name',
            'description',
            'category_id',
            'category',
        ]);

        $productQuery = $this->filterWithAttributes($request);

        $products = $productQuery->paginate(16)->appends($this->appendsColumns);

        $custom = collect([
            'min_price' => $productQuery->min('price_after_discount'),
            'max_price' => $productQuery->max('price_after_discount')
        ]);

        return $custom->merge($products);
//        dd($max_price , $min_price);
    }

    public function filterWithAttributes($request)
    {
        $productQuery = $this->paginateQuery();

        if ($request->tag || $request->brand) {
            $tag = $request->tag ?? $request->brand;
            $tag = explode(',', $tag);
            $tag = $this->replaceDashWithSpace($tag);

//            dd($tag);
//            dd($tag);
            $this->append = 1;
            $productQuery = $this->paginateOfTag(16, $tag);
        }
        if ($request->colors) {
            $colorIDs = explode(',', $request->colors);

            $productQuery = $productQuery->whereHas('variants', function ($q) use ($colorIDs) {
                $q->whereIn('color_id', $colorIDs);
            });
        }
        if ($request->size) {
            $sizeIDs = explode(',', $request->size);
//            dd($sizeIDs);
            $productQuery = $productQuery->whereHas('variants', function ($q) use ($sizeIDs) {
                $q->whereIn('dimension_id', $sizeIDs);
            });
        }
        if ($request->min_price || $request->max_price) {

            $request->min_price = $request->min_price ?? 0;
            $request->max_price = $request->max_price ?? 0;

            $productQuery = $productQuery->whereBetween('price_after_discount', [$request->min_price, $request->max_price]);
        }
        if ($request->category) {
            $category = explode(',', $request->category);

            $category = $this->replaceDashWithSpace($category);
            $tags_ids = [];
            foreach ($category as $cat) {

                $tags_ids = array_merge($tags_ids, Tag::whereHas('category', function ($q) use ($cat) {
                    $q->where('name_en', 'like', '%' . $cat . '%')
                        ->orWhere('name_ar', 'like', '%' . $cat . '%');
                })->pluck('id')->toArray());
            }
//            dd($tags_ids);

            $this->append = 1;
            $productQuery = $productQuery->whereHas('tag', function ($q) use ($tags_ids) {
                $q->whereIn('tag_id', $tags_ids);
            });
        }
//        dd($productQuery->toSql());
        return $productQuery;
    }

    public function replaceDashWithSpace($name)
    {
        for ($i = 0; $i < count($name); $i++) {
            $name[$i] = str_replace("-", " ", $name[$i]);
        }
        return $name;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        $this->setRelations([
            'variants' => function ($variant) {
                $variant->with(['color', 'dimension', 'images']);
            },
            'tag',
        ]);
        if ($request->slug) {
            $product = $this->findByColumn('slug', $request->slug);
        } else {
            $product = $this->find($request->id);
        }

        foreach ($product->variants as $variant) {
            if ($variant->dimension)
                $variant['dimension_value'] = $variant->dimension->dimension;
        }
        return $product;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function createProduct($request)
    {
        $request['slug'] = HelperFunctions::makeSlug($request->name_en) . '-' . HelperFunctions::makeSlug($request->sku);
        $product = Product::create($request->only([
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'slug',
            'stock',
            'price',
            'sku',
            'price_after_discount',
            'collection_id',
            'category_id',
            'tag_id',
            'material_id',
            'tag_id',
        ]));

        foreach ($request->variants as $variant) {

            $variant = $this->createDimension($variant);

            $variantModel = Variant::create(array_merge($variant, [
                'product_id' => $product->id
            ]));

            if (count($variant['images'])) {
                foreach ($variant['images'] as $img) {
                    $variantModel->images()->firstOrcreate([
                        'image' => $img
                    ]);
//                $variantModel->images->delete();
                }
            }
        }

        return $product;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateProduct($request)
    {
//        dd($request->all());
        $product = $this->find($request->id);
        $product->update($request->only([
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'slug',
            'stock',
            'price',
            'sku',
            'price_after_discount',
            'collection_id',
            'tag_id',
            'material_id',
            'color_id',
        ]));

        $oldVariantsIds = $product->variants()->pluck('id')->toArray();
        $arr = [];
//        dd($request->variants);
        foreach ($request->variants as $index => $variant) {

            $variant = $this->createDimension($variant, 'dimension_value');

            if ($variant['id']) {

                $variantModel = $this->variantRepo->find($variant['id']);
                $variantModel->update($variant);

                $this->updateImagesOfVariants($variant, $variantModel);

                $arr[] = $variant['id'];

            } else {
                $variantModel = Variant::create(array_merge($variant, [
                    'product_id' => $product->id
                ]));

                $this->updateImagesOfVariants($variant, $variantModel);
            }
        }

        //delete variants
        $deletedIds = array_diff($oldVariantsIds, $arr);
        $this->variantRepo->model->whereIn('id', $deletedIds)->delete();

        return $product;
    }


    public function updateImagesOfVariants($variant, $variantModel)
    {
        $hasNewFiles = 0;
        if (count($variant['images'])) {
            foreach ($variant['images'] as $img) {
                if (!is_array($img) && is_file($img) && !$hasNewFiles) {
                    $variantModel->images()->delete();
                    $hasNewFiles = 1;
                }
                if (is_array($img)) {
                    continue;
                }
                $variantModel->images()->firstOrcreate([
                    'image' => $img
                ]);
//                $variantModel->images->delete();
            }
        }
    }

    public function filter($request)
    {
        $conditions = [];
        $orConditions = [];

        if ($request->name) {
            $conditions[] = ['name_ar', 'like', '%' . $request->name . '%'];
            $orConditions[] = ['name_en', 'like', '%' . $request->name . '%'];
        }

        $this->setConditions($conditions);
        $this->setOrConditions($orConditions);
    }

    public function createDimension($variant, $key = 'dimension')
    {

        $dimension = Dimension::firstOrCreate([
            'dimension' => $variant[$key]
        ]);
        $variant['dimension_id'] = $dimension->id;

        return $variant;
    }

}

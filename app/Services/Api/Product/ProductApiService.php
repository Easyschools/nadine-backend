<?php

namespace App\Services\Api\Product;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use App\Models\Feature\Collection;
use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Models\Product\Product;
use App\Models\Product\Variant;
use App\Repositories\AppRepository;
use App\ThirdParty\Pixel;
use App\Traits\HelperFunctions;

class ProductApiService extends AppRepository
{

    private $variantRepo;

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

        $this->setSortOrder('asc');
        $this->setSortBy('sku');
        $this->setRelations([
            'variants' => function ($variant) {
                $variant->select('product_id', 'color_id', 'dimension_id', 'id')->with(
                    'Color:id,name_en,name_ar,code,image',
                    'Dimension:id,dimension',
                    'images:id,variant_id,image'
                );
            },
            'tag:id,name_en,name_ar,category_id',
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
            'min_price' => Product::min('price_after_discount'),
            'max_price' => Product::max('price_after_discount'),
        ]);

        return $custom->merge($products);
        //        dd($max_price , $min_price);
    }

    public function indexWeb($request)
    {
        $this->filter($request);

        $this->setSortOrder('asc');
        $this->setSortBy('sku');
        $this->setRelations([
            'variants' => function ($variant) {
                $variant->select('product_id', 'dimension_id', 'id')->with(
                    'Dimension:id,dimension',
                    'images:id,variant_id,image'
                );
            },
        ]);

        $this->setAppends([
            'currency',

        ]);

        $productQuery = $this->filterWithAttributes($request);

        $products = $productQuery->paginate(16);

        $custom = collect([
            'min_price' => Product::min('price_after_discount'),
            'max_price' => Product::max('price_after_discount'),
        ]);
        // return $products;
        return $custom->merge($products);
        //        dd($max_price , $min_price);
    }

    public function filterWithAttributes($request)
    {
        //        dd(implode(',',Color::pluck('id')->toArray()) );

        $productQuery = $this->paginateQuery();
        //        dd($request->all());
        if ($request->collection_name && $request->collection_name != 'sale') {
            $collection_name = str_replace('-', ' ', $request->collection_name);
            $productQuery = $productQuery->whereHas('collection', function ($q) use ($collection_name) {
                $q->where('name_en', $collection_name)->orWhere('name_ar', $collection_name);
            });
        }

        if ($request->collection_name && $request->collection_name == 'sale') {
            $productQuery = $productQuery->whereHas('offer', function ($q) {
                $q->join('offers', 'offers.id', '=', 'offer_tags.offer_id')->where('offers.expire_at', '>', now());
            })->with('offer');
        }
        if ($request->tag || $request->brand) {
            $tag = $request->tag ?? $request->brand;
            $tag = explode(',', $tag);
            $tag_names = $this->replaceDashWithSpace($tag);

            $tag_ids = [];

            foreach ($tag_names as $tag_name) {
                $arr = Tag::where('name_ar', $tag_name)->orWhere('name_en', $tag_name)->pluck('id')->toArray();
                $tag_ids = array_merge($tag_ids, $arr);
            }

            $productQuery = $productQuery->whereHas('tag', function ($q) use ($tag_ids) {
                $q->whereIn('id', $tag_ids);
            });
        }

        if ($request->color) {
            $colorIDs = explode(',', $request->color);

            $productQuery = $productQuery->whereHas('variants', function ($q) use ($colorIDs) {
                $q->whereIn('color_id', $colorIDs);
            });
        }
        if ($request->sizes) {
            $sizeIDs = explode(',', $request->sizes);

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
            if ($request->category == 'discounts') {

                $productQuery = $productQuery->WhereHas('offer')->orWhere('price_after_discount', '!=', 0);
            } else {

                $category = explode(',', $request->category);
                $category = $this->replaceDashWithSpace($category);
                $tags_ids = [];

                foreach ($category as $cat) {
                    $tags_ids = array_merge($tags_ids, Tag::whereHas('category', function ($q) use ($cat) {
                        $q->where('name_en', 'like', '%' . $cat . '%')
                            ->orWhere('name_ar', 'like', '%' . $cat . '%');
                    })->pluck('id')->toArray());
                }
                $productQuery = $productQuery->whereHas('tag', function ($q) use ($tags_ids) {
                    $q->whereIn('id', $tags_ids);
                });
            }
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
        Pixel::viewContent();
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
            if ($variant->dimension) {
                $variant['dimension_value'] = $variant->dimension->dimension;
            }
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
                'product_id' => $product->id,
            ]));

            if (count($variant['images'])) {
                foreach ($variant['images'] as $img) {
                    $variantModel->images()->firstOrcreate([
                        'image' => $img,
                    ]);
                }
            }
        }

        return $product;
    }

    public function priceRange()
    {
        return [
            'min_price' => Product::min('price_after_discount'),
            'max_price' => Product::max('price_after_discount'),
        ];
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
                    'product_id' => $product->id,
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
                    'image' => $img,
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

        if ($request->id) {
            $conditions[] = ['id', $request->id];
        }

        $this->setConditions($conditions);
        $this->setOrConditions($orConditions);
    }

    public function createDimension($variant, $key = 'dimension')
    {
        if ($variant[$key]) {
            $dimension = Dimension::firstOrCreate([
                'dimension' => $variant[$key],
            ]);
            $variant['dimension_id'] = $dimension->id;
        } else {
            $variant['dimension_id'] = null;
        }

        return $variant;
    }

    public function Product_category_search($request)
    {
        $is_arabic = preg_match('/\p{Arabic}/u', $request->search);

        if ($is_arabic) $name = 'name_ar';
        else $name = 'name_en';


        $products = Product::query()->where($name, 'LIKE', '%' . $request->search . '%')->get();
        $categories = Category::query()->where($name, 'LIKE', '%' . $request->search . '%')->get();
        $tags = Tag::query()->with(['category'])->where($name, 'LIKE', '%' . $request->search . '%')->get();

        return [
            'products' => $products,
            'categories' => $categories,
            'tags' => $tags,
        ];
    }

    public function offers($request)
    {
        $this->setRelations(['offers']);

        $products = Product::paginate(15);

        return $products;
    }

    public function getLatest($request)
    {
        return Product::orderBy('created_at', 'desc')
            ->select('id', 'slug', 'name_en', 'name_ar', 'price', 'price_after_discount', 'sku')
            ->limit(5)->get();
    }

    public function getBestSellers($request)
    {
        $products = Product::select('id', 'slug', 'name_en', 'name_ar', 'price', 'price_after_discount', 'sku')
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')->limit(10)->get();

        return $products;
    }
}

<?php

namespace App\Services\Api\Product;

use App\Models\Division\Tag;
use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Models\Product\Product;
use App\Models\Product\Variant;
use App\Repositories\AppRepository;
use App\Traits\HelperFunctions;
use Illuminate\Support\Facades\DB;


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

        $this->setRelations([
            'variants' => function ($variant) {
                $variant->select('product_id', 'image', 'color_id', 'dimension_id')->with(
                    'Color:id,name_en,name_ar,code',
                    'Dimension:id,dimension'
                );
            },
            'tag:id,name_en,name_ar,category_id'
        ]);


        $this->setAppends([
            'currency',
            'image',
            'type',
            'tags',
            'name',
            'description',
            'category_id',
            'category',
        ]);


        if ($request->tag || $request->brand) {
            $tag = $request->tag ?? $request->brand;
            $tag = implode(' ', explode('-', $tag));
//            dd($tag);
            $products = $this->paginateOfTag(16, $tag);
        } elseif ($request->category) {
            $category = implode(' ', explode('-', $request->category));

            $tags_ids = Tag::whereHas('category', function ($q) use ($category) {
                $q->where('name_en', 'like', '%' . $category . '%')
                    ->orWhere('name_ar', 'like', '%' . $category . '%');
            })->pluck('id')->toArray();

            $products = $this->paginateQuery()->whereHas('tag', function ($q) use ($tags_ids) {
                $q->whereIn('tag_id', $tags_ids);
            })->paginate(16)->appends($this->appendsColumns);

        } else {
            $products = $this->paginate(16);
        }

//        foreach ($products as  $product){
//            $product['filters']
//        }
        return $products;

    }

    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        $this->setRelations([
            'variants' => function ($variant) {
                $variant->with(['color', 'dimension']);
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
    public function priceRange()
    {
////        $query = Product::selectRaw('select p.price');
//        $this->setColumns([
//            'id',
//            'price_after_discount',
//        ]);
//         = '';
//        $result = DB::table('product')->selectRaw(
//            'select min(p.price_after_discount) as min_price
//        from products p (inner join variants v on p.id=v.product_id) ')->first()->min_price;
//        dd($result);
//        $range = $this->paginateQuery()->whereHas('variants',function ($q){
//            $q->select('addtiona_price')
//        });
//        return $product;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createProduct($request)
    {
//        dd($request->all());
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

            Variant::create(array_merge($variant, [
                'product_id' => $product->id
            ]));
        }

        return $product;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateProduct($request)
    {
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
            'tag_id',
        ]));

        $oldVariantsIds = $product->variants()->pluck('id')->toArray();
        $arr = [];
//        dd($request->variants);
        foreach ($request->variants as $variant) {

            $variant = $this->createDimension($variant, 'dimension_value');

            if ($variant['id']) {

                $variantModel = $this->variantRepo->find($variant['id']);
                $variantModel->update($variant);

                $arr[] = $variant['id'];

            } else {
                Variant::create(array_merge($variant, [
                    'product_id' => $product->id
                ]));
            }
        }

        //delete variants
        $deletedIds = array_diff($oldVariantsIds, $arr);
        $this->variantRepo->model->whereIn('id', $deletedIds)->delete();

        return $product;
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

<?php

namespace App\Services\Api\Product;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use App\Models\Feature\Collection;
use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Models\Product\ColorVariant;
use App\Models\Product\DimensionVariant;
use App\Models\Product\Product;
use App\Models\Product\ProductDetail;
use App\Models\Product\ProductImage;
use App\Models\Product\Variant;
use App\Repositories\AppRepository;
use App\ThirdParty\Pixel;
use App\Traits\HelperFunctions;
use Illuminate\Support\Facades\Storage;

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

    public function makeLook($request)
    {
        $this->filter($request);

        $this->setSortOrder($request->sort_order ?? 'desc');
        $this->setSortBy($request->sort_by ?? 'sku');
        $this->setRelations([
            'images',
            'material',
            'variants' => function ($variant) {
                $variant->select('product_id', 'color_id', 'dimension_id', 'material_id', 'id')->with(
                    'Color:id,name_en,name_ar,code,image',
                    'Dimension:id,dimension',
                    'images:id,variant_id,image'
                );
            },
            'tag:id,name_en,name_ar',
        ]);

        $this->setAppends([
            'currency',
            'type',
            'tags',
            'name',
            'description',
            // 'category_id',
            'category',
        ]);

        $productQuery = $this->filterWithAttributes($request);

        //  $products = $productQuery->paginate(16)->appends($this->appendsColumns);
        $products = $productQuery->get();
        // $products->appends($this->appendsColumns);

        //  $custom = collect([
        //      'min_price' => Product::min('price_after_discount'),
        //      'max_price' => Product::max('price_after_discount'),
        //  ]);

        return $products;
    }
    /**
     * @param $request
     * @return mixed
     */

     public function index($request)
     {
         $this->filter($request);
     
         $this->setSortOrder($request->sort_order ?? 'desc');
         $this->setSortBy($request->sort_by ?? 'sku');
         $this->setRelations([
             'images',
             'material',
             'variants' => function ($variant) {
                 $variant->select('product_id', 'color_id', 'dimension_id', 'material_id', 'id')->with(
                     'Color:id,name_en,name_ar,code,image',
                     'Dimension:id,dimension',
                     'images:id,variant_id,image'
                 );
             },
             'tag:id,name_en,name_ar',
         ]);
     
         $this->setAppends([
             'currency',
             'type',
             'tags',
             'name',
             'description',
             // 'category_id',
             'category',
         ]);
     
         $productQuery = $this->filterWithAttributes($request);
     
         if ($request->web != 1) {
             // 1. Exclude SKUs with a comma
             $productQuery->where('sku', 'not like', '%,%');
     
             // 2. Push SKUs containing 'h' to the end
             $productQuery->orderByRaw("sku LIKE '%h%'");
         }
     
         $products = $productQuery->paginate(16)->appends($this->appendsColumns);
     
         $custom = collect([
             'min_price' => Product::min('price_after_discount'),
             'max_price' => Product::max('price_after_discount'),
         ]);
     
         return $custom->merge($products);
     }
     

    public function highEnd($request)
    {
        $this->filter($request);

        $this->setSortOrder($request->sort_order ?? 'desc');
        $this->setSortBy($request->sort_by ?? 'sku');
        $this->setRelations([
            'images',
            'material',
            'collection',
            'variants' => function ($variant) {
                $variant->select('product_id', 'color_id', 'dimension_id', 'material_id', 'id')->with(
                    'Color:id,name_en,name_ar,code,image',
                    'Dimension:id,dimension',
                    'images:id,variant_id,image'
                );
            },
            'tag:id,name_en,name_ar',
        ]);

        $this->setAppends([
            'currency',
            'type',
            'tags',
            'name',
            'description',
            // 'category_id',
            'category',
        ]);

        $productQuery = $this->filterWithAttributes($request);
        $productQuery->where('sku', 'like', '%h%');

        $products = $productQuery->paginate(16)->appends($this->appendsColumns);

        $custom = collect([
            'min_price' => Product::min('price_after_discount'),
            'max_price' => Product::max('price_after_discount'),
        ]);

        return $custom->merge($products);
    }

    public function indexWeb($request)
    {
        $this->filter($request);

        $this->setSortOrder('asc');
        $this->setSortBy('sku');
        $this->setRelations([
            'images',

            'variants' => function ($variant) {
                $variant->select('product_id', 'dimension_id', 'material_id', 'id')->with(
                    'material:id,name_en',
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
    $productQuery = $this->paginateQuery();

    // Filter by collection name
    if ($request->collection_name && $request->collection_name != 'sale') {
        $collection_name = str_replace('-', ' ', $request->collection_name);
        $productQuery = $productQuery->whereHas('collection', function ($q) use ($collection_name) {
            $q->where('name_en', $collection_name)->orWhere('name_ar', $collection_name);
        });
    }

    // Filter by sale collection
    if ($request->collection_name && $request->collection_name == 'sale') {
        $productQuery = $productQuery->whereHas('offer', function ($q) {
            $q->join('offers', 'offers.id', '=', 'offer_tags.offer_id')->where('offers.expire_at', '>', now());
        })->with('offer');
    }

// Filter by tag
if ($request->has('tag') && !empty($request->tag)) {
    \Log::info('Tag Parameter:', ['tag' => $request->tag]); // Log the tag parameter
    $tags = is_array($request->tag) ? $request->tag : explode(',', $request->tag);
    $tags = $this->replaceDashWithSpace($tags);

    // Check if the first tag is numeric (indicating an ID search)
    $searchById = is_numeric($tags[0]);

    // Apply the tag filter
    $productQuery = $productQuery->whereHas('tag', function ($q) use ($tags, $searchById) {
        $q->where(function ($query) use ($tags, $searchById) {
            foreach ($tags as $tag) {
                if ($searchById) {
                    // Search by tag ID
                    $query->orWhere('id', $tag);
                } else {
                    // Search by tag name (name_en or name_ar)
                    $query->orWhere('name_en', $tag)
                          ->orWhere('name_ar', $tag);
                }
            }
        });
    });
}

// Filter by category
if ($request->has('category') && !empty($request->category)) {
    \Log::info('Category Parameter:', ['category' => $request->category]); // Log the category parameter
    $categories = is_array($request->category) ? $request->category : explode(',', $request->category);

    // Log the processed categories
    \Log::info('Processed Categories:', ['categories' => $categories]);

    // Check if the first category is numeric (indicating an ID search)
    $searchById = is_numeric($categories[0]);

    // Apply the category filter
    if ($searchById) {
        // Search by category ID
        $productQuery = $productQuery->whereIn('category_id', $categories);
    } else {
        // Search by category name (name_en or name_ar)
        $productQuery = $productQuery->whereHas('category', function ($q) use ($categories) {
            $q->where(function ($query) use ($categories) {
                foreach ($categories as $category) {
                    $query-->orWhere('name_en', $category)
                          ->orWhere('name_ar', $category);
                }
            });
        });
    }
}

    // Filter by occasional name
    if ($request->occasional_name) {
        $productQuery = $productQuery->whereHas('material', function ($q) use ($request) {
            $q->where('name_en', 'like', '%' . $request->occasional_name . '%')
              ->orWhere('name_ar', 'like', '%' . $request->occasional_name . '%');
        });
    }

    // Filter by color
    if ($request->color) {
        $colorIDs = explode(',', $request->color);
        $productQuery = $productQuery->whereHas('variants', function ($q) use ($colorIDs) {
            $q->whereIn('color_id', $colorIDs);
        });
    }

    // Filter by sizes
    if ($request->sizes) {
        $sizeIDs = explode(',', $request->sizes);
        $productQuery = $productQuery->whereHas('variants', function ($q) use ($sizeIDs) {
            $q->whereIn('dimension_id', $sizeIDs);
        });
    }

    // Filter by price range
    if ($request->min_price || $request->max_price) {
        $request->min_price = $request->min_price ?? 0;
        $request->max_price = $request->max_price ?? 0;
        $productQuery = $productQuery->whereBetween('price_after_discount', [$request->min_price, $request->max_price]);
    }

    // Log the final query
    \Log::info('Final Query:', [
        'sql' => $productQuery->toSql(),
        'bindings' => $productQuery->getBindings()
    ]);

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
    public function getVariants($request)
    {
        $variant = Variant::where('product_id', $request->product_id)
            ->where('material_id', $request->material_id)
            ->with('ColorVariant', 'DimensionVariant')->first();

        return $variant;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        $this->setSortOrder($request->sort_order ?? 'desc');

        // Pixel::viewContent();
        $this->setRelations([
            'images',

            'variants' => function ($variant) {
                $variant->with([
                    'color',
                    'dimension',
                    'images',
                    'material',
                    'ColorVariant',
                    'DimensionVariant',
                ]);
            },
            'tag',
            'collection'
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
        $materials = []; // Initialize an empty array to store materials

        foreach ($product->variants as $variant) {
            if ($variant->material) {
                $materialId = $variant->material->id;
                if (!isset($materials[$materialId])) { // Check if material ID already exists in array
                    $materialDetails = [
                        'id' => $materialId,
                        'name' => $variant->material->name,
                    ];
                    $materials[$materialId] = $materialDetails; // Use material ID as key in array
                }
            }
        }

        $product['materials'] = array_values($materials); // Re-index the array keys and assign to the product
        // if ($product['sub_product'] != null) {
        // If it's not an object, assign it to sub_product directly
        $product['sub_product'] = $product->subProductImages() ?? [];
        // }
        // $product['sub_product'] = $product->subProductImages();
        return $product;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getSubProduct($request)
    {

        $this->setRelations([
            'images',
            'variants' => function ($variant) {
                $variant->with(['color', 'dimension', 'images', 'material']);
            },
            'tag',
        ]);
        if ($request->slug) {
            $product = $this->findByColumn('slug', $request->slug);
        } else {
            $product = $this->find($request->id);
        }
        // Extract sub_products array from the retrieved product
        $subProducts = $product->sub_products;
        // Retrieve products where sub_products column contains any of the values in $subProducts array
        $products = Product::whereIn('id', $subProducts)->get();
        foreach ($products as $product) {
            if ($product !== null) {
                foreach ($product->variants as $variant) {
                    if ($variant->dimension) {
                        $variant['dimension_value'] = $variant->dimension->dimension;
                    }
                }
            }
        }

        return $products;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function createProduct($request)
    {
        // dd($request->files);
        // dd($request->files[0]['originalName']);
        // dd($request->all());
        $request['slug'] = HelperFunctions::makeSlug($request->name_en) . '-' . HelperFunctions::makeSlug($request->sku);
        // $product = Product::create($request->only([
        //     'name_ar',
        //     'name_en',
        //     'description_ar',
        //     'description_en',
        //     'slug',
        //     'stock',
        //     'price',
        //     'sku',
        //     'price_after_discount',
        //     'collection_id',
        //     'category_id',
        //     'tag_id',
        //     'material_id',
        //     'tag_id',
        //     'limited_edition',
        //     'best_selling',
        //     'new_arrival',
        //     'files'
        // ]));

        // Create the product with other attributes and include sub_products in the data array
        // Assuming $request->product_id contains the array you provided
        // $ids = array_column($request->product_id, 'id');

        // Now $ids contains only the IDs from the original array
        $product = Product::create(array_merge(
            $request->only([
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
                'limited_edition',
                'best_selling',
                'new_arrival',
                'image',
            ]),
            [
                'sub_products' => $request->product_id,
                'files' => $request->files ?? null
            ]
        ));

        if (count($request->images)) {
            foreach ($request->images as $img) {
                // Assuming $img contains the file path of each image
                $productImage = new ProductImage();
                $productImage->image = $img; // Set the image attribute
                $productImage->product_id = $product->id; // Assuming $product is the current product
                $productImage->save();
            }
        }

        foreach ($request->variants as $variant) {
            // $variant = $this->createDimension($variant);
            $variantModel = Variant::create([
                'material_id' => $variant['material_id'],
                'additional_price' => $variant['additional_price'],
                // 'dimension_id' => $variant['dimension_id'],
                'product_id' => $product->id,
            ]);
            // $variantModel = Variant::create(array_merge($variant, [
            //     'product_id' => $product->id,
            // ]));
            // Attach colors to the variant
            if (isset($variant['color_id']) && is_array($variant['color_id'])) {
                foreach ($variant['color_id'] as $color) {
                    // Find or create the color variant
                    $colorVariant = ColorVariant::Create([
                        'variant_id' => $variantModel->id,
                        'color_id' => $color['id'],
                    ]);
                }
            }
            if (isset($variant['dimension_id']) && is_array($variant['dimension_id'])) {
                foreach ($variant['dimension_id'] as $dimension) {
                    // Find or create the color variant
                    $colorVariant = DimensionVariant::Create([
                        'variant_id' => $variantModel->id,
                        'dimension_id' => $dimension['id'],
                    ]);
                }
            }

            if (count($variant['images'])) {
                foreach ($variant['images'] as $img) {

                    $file = explode(";base64,", $img);
                    $file1 = explode('/', $file[0]);
                    $file_exe = end($file1);
                    $file_name = uniqid() . date('-Ymd-his.') . $file_exe;
                    $image_data = str_replace('.', '', $file[1]);

                    Storage::put('uploads/Variant/' . $file_name, base64_decode($image_data));


                    // $image_data = $request->input('image_data');
                    // $image = base64_decode($img);
                    // $image_name = uniqid('image_') ;
                    // $image_path = storage_path('app/public/uploads/Variant/' . $image);
                    // file_put_contents($image_path, $image);
                    // dd($file_name);
                    $variantModel->images()->firstOrcreate([
                        'image' => 'uploads/Variant/' . $file_name,
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
        // dd(isFile($request->imagges[0])?'yes':'no');
        $product = $this->find($request->id);
        if ($request->hasFile('files')) {
            $files = $request->files;
        } else {
            $files = $product->files;
        }
        // $product->update($request->only([
        //     'name_ar',
        //     'name_en',
        //     'description_ar',
        //     'description_en',
        //     'slug',
        //     'stock',
        //     'price',
        //     'sku',
        //     'price_after_discount',
        //     'collection_id',
        //     'tag_id',
        //     'material_id',
        //     'color_id',
        //     'limited_edition',
        //     'best_selling',
        //     'new_arrival',
        //     'files'

        // ]));
        // dd($request->category_id);
        $product->update(array_merge(
            $request->only([
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
                'category_id',
                'color_id',
                'limited_edition',
                'best_selling',
                'new_arrival',
                'image',
            ]),
            [
                'sub_products' => $request->sub_products,
                'files' => $files
            ]
        ));

        // Update product images
        if (isset($request->images)) {
            // Step 1: Delete all existing product images for the product ID
            $productImage =  ProductImage::where('product_id', $request->id)->delete();
            // dd($request->images,$productImage);
            // Step 2: Insert new images into the database
            foreach ($request->images as $image) {
                if ($image instanceof \Illuminate\Http\UploadedFile) {
                    // New image uploaded by the user
                    $productImage = new ProductImage();
                    $productImage->image = $image; // Store the uploaded image and get its path
                    $productImage->product_id = $request->id;
                    $productImage->save();
                } elseif (is_array($image) && isset($image['image']) && !empty($image['image'])) {
                    // Existing image, insert it
                    // dd($image['image']);
                    $productImage = ProductImage::create([
                        'image' => $image['image'],
                        'product_id' => $request->id
                    ]);
                    // $productImage = new ProductImage();

                    // $productImage->image = $image['image']; // Ensure the 'image' field is assigned a value
                    // $productImage->product_id = $request->id;
                    // $productImage->save();
                }
            }
        }



        $oldVariantsIds = $product->variants()->pluck('id')->toArray();
        $arr = [];
        //        dd($request->variants);
        // foreach ($request->variants as $index => $variant) {

        //     $variant = $this->createDimension($variant, 'dimension_value');

        //     if (isset($variant['id']) && $variant['id']) {

        //         $variantModel = $this->variantRepo->find($variant['id']);
        //         $variantModel->update($variant);

        //         $this->updateImagesOfVariants($variant, $variantModel);

        //         $arr[] = $variant['id'];
        //     } else {
        //         $variantModel = Variant::firstOrCreate([
        //             'color_id' => $variant['color_id'],
        //             'dimension_id' => $variant['dimension_id'],
        //             'product_id' => $product->id,
        //             'additional_price' => $variant['additional_price'],
        //         ], []);

        //         $this->updateImagesOfVariants($variant, $variantModel);
        //     }
        // }

        foreach ($request->variants as $index => $variant) {

            // $variant = $this->createDimension($variant, 'dimension_value');
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



            // Update or create color variants
            if (isset($variant['color_variant']) && is_array($variant['color_variant'])) {
                foreach ($variant['color_variant'] as $color) {

                    ColorVariant::updateOrCreate(
                        [
                            'variant_id' => $variantModel->id,
                            'color_id' => $color['id'],
                        ],
                        [
                            'color_id' => $color['id'],
                        ]
                    );
                }
            }

            // Update or create dimension variants
            if (isset($variant['dimension_variant']) && is_array($variant['dimension_variant'])) {
                foreach ($variant['dimension_variant'] as $dimension) {
                    DimensionVariant::updateOrCreate(
                        [
                            'variant_id' => $variantModel->id,
                            'dimension_id' => $dimension['id'],
                        ],
                        [
                            'dimension_id' => $dimension['id'],

                        ]
                    );
                }
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
        if (isset($variant['images']) && count($variant['images'])) {
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
        if (isset($variant[$key]) && $variant[$key]) {
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


        $products = Product::query()->with('images')->where($name, 'LIKE', '%' . $request->search . '%')->get();
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
            ->select('id', 'slug', 'name_en', 'name_ar', 'price', 'price_after_discount', 'sku', 'tag_id')
            ->with([
                'variants:id,color_id,dimension_id,additional_price,product_id',
                'variants.color:id,name_en,name_ar',
                'variants.dimension:id,dimension',
            ])
            ->limit(5)->get();
    }



    public function getBestSellers($request)
    {
        $products = Product::select('id', 'price', 'price_after_discount', 'slug', 'name_en', 'name_ar')
            ->with([
                'images',

                'variants:id,color_id,dimension_id,additional_price,product_id',
                'variants.color:id,name_en,name_ar',
                'variants.dimension:id,dimension',
            ])
            ->where('best_selling', 1)
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')->paginate();

        return $products;
    }
    public function getLimitedEdtion($request)
    {
        $products = Product::select('id',  'price', 'price_after_discount', 'slug', 'name_en', 'name_ar')
            ->with([
                'images',

                'variants:id,color_id,dimension_id,additional_price,product_id',
                'variants.color:id,name_en,name_ar',
                'variants.dimension:id,dimension',
            ])
            ->where('limited_edition', 1)
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')->paginate();

        return $products;
    }
    public function getNewArrival($request)
    {
        $products = Product::select('id', 'slug', 'name_en', 'name_ar')
            ->with([
                'productImages',
                'variants:id,color_id,dimension_id,additional_price,product_id',
                'variants.color:id,name_en,name_ar',
                'variants.dimension:id,dimension',
            ])
            ->where('new_arrival', 1)
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')->paginate(3);

        return $products;
    }
}

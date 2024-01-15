<?php

namespace App\Http\Controllers\HighJewellery;

use App\Http\Controllers\Controller;
use App\Http\Requests\HighJewellery\CollectionCreateRequest;
use App\Http\Requests\HighJewellery\CollectionUpdateRequest;
use App\Http\Requests\HighJewellery\CreateCollectionRequest;
use App\Http\Resources\HighJewellery\AllCollectionResource;
use App\Http\Resources\HighJewellery\CollectionResource;
use App\Models\HighJewellery\HighJewelleryCollection;
use Illuminate\Http\Request;

class HighJewelleryCollectionsController extends Controller
{
    public function create(CollectionCreateRequest $request)
    {
        $request->merge([
            'slug' => \Illuminate\Support\Str::slug($request->title),
        ]);
        $collection = HighJewelleryCollection::create($request->all());
        return new CollectionResource($collection);
    }

    public function update(CollectionUpdateRequest $request)
    {
        $collection = HighJewelleryCollection::where('id', $request->collection_id)->first();
        if (isset($collection)) {
            $collection->update([
                'slug' => $request->title ? \Illuminate\Support\Str::slug($request->title) : $collection->slug,
                'title' => $request->title ?? $collection->title,
                'image' => $request->image ?? $collection->image,
                'description' => $request->description ?? $collection->description,
                'design_target_desc' => $request->design_target_desc ?? $collection->design_target_desc,
                'design_target_img' => $request->design_target_img ?? $collection->design_target_img
            ]);
            return new CollectionResource($collection);
        }
    }

    public function all()
    {
        $collections = HighJewelleryCollection::paginate();
        return AllCollectionResource::collection($collections);
    }

    public function get($collection_id)
    {
        $collection = HighJewelleryCollection::whereId($collection_id)->first();
        if (isset($collection)) {
            return new CollectionResource($collection);
        }
    }

    public function filter(Request $request)
    {
        if ($request->slug) {
            $collection = HighJewelleryCollection::where('slug', $request->slug)->first();
            if (isset($collection)) {
                return new CollectionResource($collection);
            }
        }
    }
}

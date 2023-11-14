<?php

namespace App\Services\Api\Order;

use App\Models\Order\Offer;
use App\Models\Order\OfferTag;
use App\Repositories\AppRepository;
use Illuminate\Support\Facades\DB;

class OfferApiService extends AppRepository
{
    public function __construct(Offer $offer)
    {
        parent::__construct($offer);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->setRelations([
            'category',
        ]);
        if ($request->is_paginate == 1) {
            return $this->paginate();
        }
        return $this->all();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        $this->setRelations([
            'tags',
            'category:id,slug,name_'. app()->getLocale()
        ]);
        return $this->find($request->id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createOffer($request)
    {
        $offer = $this->model->create($request->only(
            'name_ar',
            'name_en',
            'is_percentage',
            'discount',
            'category_id',
            'expire_at'
        ));

        foreach ($request->tags as $tag) {
            $data = [
                'offer_id' => $offer->id,
                'tag_id' => $tag,
            ];
            OfferTag::create($data);
        }
    }
    /**
     * @param $request
     * @return mixed

     */

    public function editOffer($request)
    {
        $model = $this->find($request->id);
        $model = $model->update($request->only(
            'name_ar',
            'name_en',
            'is_percentage',
            'discount',
            'image',
            'category_id',
            'expire_at'
        ));
        DB::table("offer_tags")->where('offer_id', $request->id)->delete();

        foreach ($request->tags as $tag) {
            $data = [
                'tag_id' => $tag,
                'offer_id' => $request->id,
            ];

            $offerTag = OfferTag::create($data);
        }
        return $model;
    }
}

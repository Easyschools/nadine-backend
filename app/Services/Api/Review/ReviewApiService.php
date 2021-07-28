<?php

namespace App\Services\Api\Review;

use App\Models\Review\Review;
use Illuminate\Http\Request;
use \App\Repositories\AppRepository;

class ReviewApiService extends AppRepository
{
    public function __construct(Review $review)
    {
        parent::__construct($review);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createReview($request)
    {

        return $this->model->create([
            'product_id' => $request->product_id,
            'star' => $request->star,
            'name' => $request->name,
            'email' => $request->email,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateReview($request)
    {
        $review = $this->find($request->id);
        return $review->update([
            'product_id' => $request->product_id,
            'star' => $request->star,
            'name' => $request->name,
            'email' => $request->email,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);
    }

    public function index(Request $request)
    {
        $this->setRelations([
            'product',
        ]);
        $this->setConditions(['product_id' => $request->product_id]);
        $this->setSortOrder();
        if ($request->is_paginate) {
            return $this->paginate();
        }

        return $this->all();
    }

    public function get(Request $request)
    {
        $this->setRelations([
            'product' => function ($product) {
                $product->select('id', 'name_ar', 'tag_id', 'name_en', 'material_id');
            },
        ]);
        $this->setRelations([
            'product',
        ]);

        return $this->find($request->id);
    }

}

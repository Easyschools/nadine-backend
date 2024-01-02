<?php

namespace App\Services\Api\MediaPress;

use App\Models\MediaPress\MediaPress;
use App\Repositories\AppRepository;


class MediaPressApiService extends AppRepository
{

    public function __construct(MediaPress $mediaPress)
    {
        parent::__construct($mediaPress);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
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
        return $this->find($request->id);
    }



    /**
     * @param $request
     * @return mixed
     */
    public function createMediaPress($request)
    {
        $model = $this->model->create($request->only([
            'name_ar',
            'name_en',
            'image',
            'url',
            'type',
        ]));
        return $model;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editMediaPress($request)
    {

        $model = $this->find($request->id);

        // Handle 'image' separately to set it to null if it's not provided
        $updateData = $request->only([
            'name_ar',
            'name_en',
            'type',
        ]);

        // Check if 'image' is provided in the request
        if ($request->type == 'image'||  $request->type == 'article') {
            $updateData['image'] = $request->image;
        } else {
            $updateData['image'] = null;
        }
        // Check if 'url' is provided in the request
        if ($request->type == 'video' || $request->type == 'article') {
            $updateData['url'] = $request->url;
        } else {
            // If 'image' is not provided, set it to null
            $updateData['url'] = null;
        }


        $result = $model->update($updateData);

        return $result;
    }
}

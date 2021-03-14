<?php

namespace App\Services\Api\Region;

use App\Models\Region\City;
use App\Models\Region\District;
use App\Repositories\AppRepository;
use App\Traits\HelperFunctions;


class CityApiService extends AppRepository
{

    public function __construct(City $city)
    {
        parent::__construct($city);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->filter($request);

        $this->setRelations(['districts']);

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
        $this->setRelations(['districts']);

        return $this->find($request->id);
    }


    /**
     * @param $request
     * @return mixed
     */
    public function createCity($request)
    {
        $city = City::create($request->only([
            'name_ar',
            'name_en',
        ]));

        foreach ($request->districts as $district) {
            District::create(array_merge($district, [
                'city_id' => $city->id
            ]));
        }

        return $city;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function editCity($request)
    {
        $city = $this->find($request->id);

        $city->update($request->only([
            'name_ar',
            'name_en',
        ]));

        $oldVariantsIds = $city->districts()->pluck('id')->toArray();

        HelperFunctions::CurdOperation($request, $city, new District, 'districts', 'city', $oldVariantsIds);


        return $city;
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


}

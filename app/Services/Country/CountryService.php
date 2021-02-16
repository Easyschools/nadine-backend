<?php

namespace App\Services\Payment;

use App\Models\Country\Country;
use App\Repositories\AppRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Class CountryService extends AppRepository
{

    public function __construct(Country $country)
    {
        parent::__construct($country);
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


    public function create(Request $request)
    {
        return $this->model->create($request->only([
            'name_ar',
            'name_en',
            'icon',
            'is_banned',
        ]));
    }


    public function updatePayment(Request $request)
    {
        $request['is_banned'] = $request->active ? 0 : 1;
        $process = $this->update($request->id, $request->only([
            'name_en', 'name_ar', 'is_banned', 'icon'
        ]));
        return $process;
    }


}

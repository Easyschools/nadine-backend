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
        $request['is_default'] = $request->is_default == 0 ? 0 : 1;

        return $this->model->create($request->all());
    }


}

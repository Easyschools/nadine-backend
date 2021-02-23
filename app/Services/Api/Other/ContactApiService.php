<?php


namespace App\Services\Api\Other;

use App\Models\Other\Contact;
use \App\Repositories\AppRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactApiService extends AppRepository
{
    public function __construct(Contact $contact)
    {
        parent::__construct($contact);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createContact($request)
    {
        return $this->model->create([
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'message' => $request->message,
        ]);
    }


    public function index(Request $request)
    {
        if ($request->is_paginate)
            return $this->paginate();
        return  $this->all();

    }


    public function get(Request $request)
    {
        return $this->find($request->id);
    }


}

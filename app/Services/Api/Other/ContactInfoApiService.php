<?php


namespace App\Services\Api\Other;

use App\Models\Other\Contact;
use App\Models\Other\ContactAddress;
use App\Models\Other\ContactInfo;
use App\Models\User\Address;
use \App\Repositories\AppRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactInfoApiService extends AppRepository
{
    private $contactAddressService;

    public function __construct(ContactInfo $contactInfo)
    {
        $this->contactAddressService = new AppRepository(new ContactAddress());

        parent::__construct($contactInfo);
    }


    public function updateOrCreateContactAddress($request)
    {
        if ($request->addresses) {

            foreach ($request->addresses as $address) {
                $this->contactAddressService->model->firstOrCreate([
                    'latitude' => $address['latitude'],
                    'longitude' => $address['longitude'],
                    'address' => $address['address'],
                ]);
            }
        }

    }

    /**
     * @param $request
     * @return mixed
     */
    public function createContactInfo($request)
    {

        $this->updateOrCreateContactAddress($request);

        return $this->model->create([
            'phones' => $request->phones,
            'emails' => $request->emails,
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateContactInfo($request)
    {
        $this->updateOrCreateContactAddress($request);

        $contactInfo = $this->find(1);

        return $contactInfo->update([
            'phones' => $request->phones,
            'emails' => $request->emails,
        ]);
    }


    public function index(Request $request)
    {
        if ($request->is_paginate)
            $result = $this->paginate();
        $result = $this->all();

        $addresses = $this->contactAddressService->all();

        return [
            $result,
            'addresses' => $addresses
        ];

    }


    public function get(Request $request)
    {
        $addresses = $this->contactAddressService->all();

        return [
            $this->find(1),
            'addresses' => $addresses
        ];
    }


}

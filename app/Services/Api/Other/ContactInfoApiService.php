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
        ContactAddress::truncate();

        if ($request->addresses) {

            foreach ($request->addresses as $address) {
                $this->contactAddressService->model->Create([
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

        $contactInfo = ContactInfo::first();

        return $contactInfo->update([
            //            'phones' => implode(',', $request->phone),
            //            'emails' => implode(',', $request->email),
            'phones' => $request->phone,
            'emails' => $request->email,
        ]);
    }


    public function index(Request $request)
    {
        $result = $request->is_paginate ? $this->paginate() : $this->all();

        $addresses = $this->contactAddressService->all();

        return [
            $result,
            'addresses' => $addresses
        ];
    }

    public function indexAll(Request $request)
    {
        $result = $request->is_paginate ? $this->paginate() : $this->all();

        $addresses = $this->contactAddressService->all();

        return [
            "contacts" => $result,
            'addresses' => $addresses
        ];
    }


    public function get(Request $request)
    {
        $addresses = $this->contactAddressService->all();
        $result = $this->model->first();
        $result['addresses'] = $addresses;
        return $result;
    }
}

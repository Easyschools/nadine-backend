<?php

namespace App\Services\Api\Auth;

use App\Models\User\User;
use App\Repositories\AppRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerApiService extends AppRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    private function getUserId($userId)
    {
        $user = Auth::user();

        return ($user->type == 1) ? $userId : $user->id;
    }

    public function updateCustomer(Request $request)
    {
        $userId = $this->getUserId($request->user_id);

        $this->setConditions([['type', 2]]);

        $request->merge([
            'verified_code' =>
                ($request->phone && $request->phone != Auth::user()->phone) ? 0 : null,
            'phone_verified_at' => ($request->phone && $request->phone != Auth::user()->phone) ?
                null : Auth::user()->phone_verified_at
        ]);

        $user = $this->update($userId,
            $request->only([
                'phone',
                'name',
                'image',
                'phone_verified_at',
                'verified_code',
                'email',
                'email_verified_at',
            ]));

        return true;
    }


    public function get($id)
    {
        $userId = $this->getUserId($id);

//        $this->setColumns(['id', 'name', 'phone', 'is_ban', 'type', 'phone_verified_at']);
        $user = $this->find($userId);

        return $user;
    }

    public function deleteCustomer($id)
    {
        $this->setConditions([['type', 4]]);
        $user = $this->find($id);
        if (!$user) {
            return false;
        }
        if ($user->basicInfo()->first() != null) {
            $user->basicInfo()->first()->delete();
        }
        return $this->delete($id);
    }

    public function index(Request $request)
    {

        $this->setConditions([['type', 2]]);

        if ($request->is_paginate != 1) {
            return $this->all();
        }
        return $this->paginate();
    }
}

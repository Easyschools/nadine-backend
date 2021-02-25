<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $k = count($this->segments());
        $endPoint = $this->segment($k);
        switch ($endPoint) {
            case 'status':
                return $this->updateStatusRules();
            case 'grand-total':
                return $this->grandTotal();
            case 'checkout':
                return $this->checkout();
            case 'order-details':
                return $this->orderDetails();
            case 'search':
                return $this->search();
            case 'delete':
                return $this->orderIdRules();
            default:
                return [];
        }
    }

    private function orderIdRules()
    {
        return [
            'order_id' => 'required|exists:orders,id'
        ];
    }

    private function updateStatusRules()
    {
        return [
            'status' => 'required|in:1,2,3,4,5',
            'id' => 'required|exists:orders,id',
        ];
    }
    private function grandTotal()
    {
        return [
            'payment_type_id' => 'exists:payment_methods,code',
            'code' => 'exists:coupons,code',
            'address_id' => 'required|exists:addresses,id',
        ];
    }

    private function checkout()
    {
        return [
//            'token' => 'required|exists:users,hash_token',
            'address_id' => 'required|exists:addresses,id',
            'code' => 'exists:coupons,code',
            'payment_type_id' => 'required|exists:payment_types,id',
//            'Amount' => 'required',
//            'Currency' => 'required',
//            'MerchantReference' => 'required',
//            'NetworkReference' => 'required',
//            'PaidThrough' => 'required',
//            'PayerAccount' => 'required',
//            'PayerName' => 'required',
//            'SecureHash' => 'required',
//            'SystemReference' => 'required',
//            'TxnDate' => 'required',
        ];
    }

    private function orderDetails()
    {
        return [
            'order_id' => 'required|exists:orders,id',
        ];
    }

    private function search()
    {
        return [
            'status' => 'in:1,2,3,4,5',
            'key' => 'min:1',
        ];
    }


}

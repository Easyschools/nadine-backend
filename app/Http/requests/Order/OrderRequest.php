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
            case 'grand-total':
                return $this->grandTotalValidation();
            case 'checkout':
                return $this->checkoutValidation();
            case 'order-details':
                return $this->orderIdValidation();
            case 'user-orders':
                return $this->userIdValidation();
            case 'assign-technician':
                return $this->assignTechnicianValidation();
            case 'update-status':
                return $this->updateStatusValidation();
            case 'update-payment':
                return $this->updatePaymentValidation();
            case 'recalculate':
            case 'update':
                return $this->recalculateValidation();
            case 'confirm-slots':
                return $this->confirmSlotsValidation();
            case 'filter':
                return $this->filter();
            default:
                return [];
        }
    }

    private function grandTotalValidation()
    {
        return [
            'day' => 'required|date_format:Y-m-d|date|after_or_equal:today',
            'address_id' => 'required|exists:addresses,id',
            'code' => 'exists:coupons,code',
            'slot_id' => 'required|exists:slots,id',
        ];
    }

    private function checkoutValidation()
    {
        return [
            'day' => 'required|date_format:Y-m-d|date|after_or_equal:today',
            'address_id' => 'required|exists:addresses,id',
            'code' => 'exists:coupons,code',
            'car_id' => 'required|exists:cars,id',
            'slot_id' => 'required|exists:slots,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'note' => 'min:2|max:400',
        ];
    }

    private function orderIdValidation()
    {
        return [
            'id' => 'required|exists:orders,id',
        ];
    }

    private function assignTechnicianValidation()
    {
        return [
//            'technician_id' => 'exists:users,id',
            'order_id' => 'required|exists:orders,id',
        ];
    }


    private function updateStatusValidation()
    {
        return [
            'status' => 'required|between:1,13',
            'id' => 'required|exists:orders,id',
        ];
    }

    private function updatePaymentValidation()
    {

        return [
            'payment_type_id' => 'required|exists:payment_types,id',
            'id' => 'required|exists:orders,id',
        ];
    }

    private function recalculateValidation()
    {
        return [
            'note' => 'min:2|max:400',
            'day' => 'date_format:Y-m-d|date|after_or_equal:today',
            'id' => 'required|exists:orders,id',
            'car_id' => 'exists:cars,id',
            'slot_id' => 'exists:slots,id',
            'items' => 'required|array',
            'items.*' => 'required|exists:model_service,id',
            'address_id' => 'exists:addresses,id',
        ];
    }


    private function confirmSlotsValidation()
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'slot_id' => 'required|exists:slots,id',
        ];
    }

    private function filter()
    {
        return [
            'from' => 'date_format:Y-m-d|date',
            'to' => 'date_format:Y-m-d|date',
            'slot_id' => 'exists:slots,id',
            'status' => 'between:1,13',
            'waiting_orders' => 'boolean',
        ];
    }

    private function userIdValidation()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
        ];
    }


}

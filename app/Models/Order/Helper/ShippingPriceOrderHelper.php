<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/04/21
 * Time: 03:08 م
 */

namespace App\Models\Order\Helper;


trait ShippingPriceOrderHelper
{

    public function calculateDependingOnCustomTagPrice($customShippingPrice , $item)
    {

        if ($this->address->district->city->name_en == 'cairo') {
            $this->shippingPrice += ($customShippingPrice->cost_inside_cairo* $item->quantity);
        } else {
            $this->shippingPrice += ($customShippingPrice->cost_outside_cairo *$item->quantity);
        }
    }
}

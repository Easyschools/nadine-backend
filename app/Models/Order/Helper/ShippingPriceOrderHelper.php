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

    public function calculateDependingOnCustomTagPrice($customShippingPrice)
    {

        if ($this->address->district->city->name_en == 'cairo') {
            $this->shippingPrice += $customShippingPrice->cost_inside_cairo;
        } else {
            $this->shippingPrice += $customShippingPrice->cost_outside_cairo;
        }
    }
}

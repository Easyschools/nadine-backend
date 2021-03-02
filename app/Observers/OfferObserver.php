<?php

namespace App\Observers;


use App\Models\Order\Offer;
use App\Traits\HelperFunctions;

class OfferObserver
{

    public function deleted(Offer $offer)
    {
        HelperFunctions::removeImage($offer->image);
    }

    public function updating(Offer $offer)
    {
        if ($offer->isDirty('image')) {
            HelperFunctions::removeImage($offer->getOriginal('image'));
        }
    }

}

<?php

namespace App\Observers;


use App\Models\Product\VariantImage ;
use App\Traits\HelperFunctions;

class VariantImageObserver
{

    public function deleted(VariantImage $variantImage)
    {
        HelperFunctions::removeImage($variantImage->image);
    }

    public function updating(VariantImage $variantImage)
    {
        if ($variantImage->isDirty('image')) {
            HelperFunctions::removeImage($variantImage->getOriginal('image'));
        }
    }

}

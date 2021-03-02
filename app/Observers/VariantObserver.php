<?php

namespace App\Observers;


use App\Models\Product\Variant;
use App\Traits\HelperFunctions;

class VariantObserver
{

    public function deleted(Variant $variant)
    {
        HelperFunctions::removeImage($variant->image);
    }

    public function updating(Variant $variant)
    {
        if ($variant->isDirty('image')) {
            HelperFunctions::removeImage($variant->getOriginal('image'));
        }
    }

}

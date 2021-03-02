<?php

namespace App\Observers;


use App\Models\Feature\Brand;
use App\Traits\HelperFunctions;

class BrandObserver
{

    public function deleted(Brand $brand)
    {
        HelperFunctions::removeImage($brand->image);
    }

    public function updating(Brand $brand)
    {
        if ($brand->isDirty('image')) {
            HelperFunctions::removeImage($brand->getOriginal('image'));
        }
    }

}

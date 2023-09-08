<?php

namespace App\Observers;


use App\Models\Division\Tag;
use App\Traits\HelperFunctions;

class TagObserver
{

    public function deleted(Tag $tag)
    {
        HelperFunctions::removeImage($tag->image);
    }

    public function updating(Tag $tag)
    {
        if ($tag->isDirty('image')) {
            HelperFunctions::removeImage($tag->getOriginal('image'));
        }
    }

}

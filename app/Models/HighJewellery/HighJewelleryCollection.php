<?php

namespace App\Models\HighJewellery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighJewelleryCollection extends Model
{
    use HasFactory;
    protected $table = 'high_jewellery_collections';
    protected $fillable = ['slug', 'title', 'image', 'description', 'design_target_desc', 'design_target_img'];

    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (!is_array($value)) {
            if (is_file($value))
                $this->attributes['image'] = 'uploads/' . $value->store('high-jewellery/collections');
        }
    }

    public function getDesignTargetImgAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setDesignTargetImgAttribute($value)
    {
        if (!is_array($value)) {
            if (is_file($value)) {
                $this->attributes['design_target_img'] = 'uploads/' . $value->store('high-jewellery/design-target');
            }
        }
    }
}

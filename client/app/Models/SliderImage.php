<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderImage extends Model
{
    public function scopeActiveStatus($query){
        $query->where('status', 1);
    }
}

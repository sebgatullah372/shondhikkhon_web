<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function scopeActiveStatus($query){
        $query->where('status', 1);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function scopeActiveStatus($query){
        $query->where('status', 1);
    }

}

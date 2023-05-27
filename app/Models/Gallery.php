<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public function scopeShowOnHome($query){
        $query->where('show_on_home', 1);
    }
}

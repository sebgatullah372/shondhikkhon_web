<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function album(){
        return $this->hasOne(Album::class);
    }
    public function scopeActiveStatus($query){
        $query->where('status', 1);
    }

}

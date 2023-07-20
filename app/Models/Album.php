<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */

    public function galleries(){
        return $this->hasMany(Gallery::class);
    }
}

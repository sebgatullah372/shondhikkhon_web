<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $guarded = [];

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function service(){
        return $this->belongsTo(Service::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */

    public function galleries(){
        return $this->hasMany(Gallery::class);
    }
}

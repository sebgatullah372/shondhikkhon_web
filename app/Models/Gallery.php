<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{

    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function album(){
        return $this->belongsTo(Album::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function galleryImages(){
        return $this->hasMany(GalleryImage::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
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
    public function gallery_images(){
        return $this->hasMany(GalleryImage::class);
    }

    public function scopeShowOnHome($query){
        $query->where('show_on_home', 1);
    }
}

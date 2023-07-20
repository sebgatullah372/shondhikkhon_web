<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function show($id){
        $gallery = Gallery::find($id);
        return view('gallery.show', compact('gallery'));
    }
}

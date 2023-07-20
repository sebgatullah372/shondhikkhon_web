<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function show($id){
        $album = Album::with('galleries')->find($id);
        return view('album.show', compact('album'));
    }
}

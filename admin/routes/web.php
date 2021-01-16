<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Auth::routes();

Route::group(['middleware'=> ['auth']], function(){

    Route::get('/home', 'HomeController@index')->name('home');
    //========================Album Routes======================================
    Route::resource('albums', 'AlbumController', ['names'=> 'albums']);
    //==========================================================================

    //=======================Gallery Routes=====================================
    Route::post('gallery/store/{album}', 'GalleryController@storeGalleryByAlbum')->name('store_gallery_by_album');
    Route::resource('galleries', 'GalleryController', ['names'=> 'galleries']);
    //==========================================================================


});


Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('admin/login', 'Auth\AdminLoginController@login')->name('admin.login.post');
Route::get('admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');


Route::get('/welcome', function () {
    return view('welcome');
});

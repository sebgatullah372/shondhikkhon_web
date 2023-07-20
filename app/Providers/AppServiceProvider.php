<?php

namespace App\Providers;

use App\Models\Album;
use App\Models\Contact;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer('*', function($view){
            $adminUrl = Config::get('admin_panel.url');
            $siteSettings = SiteSetting::find(1);
            $contactInformation = Contact::find(1);
            $view->with('adminUrl', $adminUrl)
                ->with('siteSettings', $siteSettings)
                ->with('contactInformation' , $contactInformation);
        });
        View::composer('includes.header', function($view){
            $albums = Album::select('id', 'name')->get();
            $view->with('albums', $albums);
        });
    }
}

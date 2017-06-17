<?php

namespace App\Providers;

use Auth;
use Hash;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('passcheck', function($attribute, $value, $parameters)
        {
            return Hash::check($value, Auth::user()->getAuthPassword());
        });

        Validator::extend('usernamecheck', function($attribute, $value, $parameters)
        {
            if (in_array($value, ['posts', 'search', 'groups', 'groups', 'post', 'home', 'follow'])) return false;
            $filter = "[^a-zA-Z0-9\-\_\.]";
            return preg_match("~" . $filter . "~iU", $value) ? false : true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

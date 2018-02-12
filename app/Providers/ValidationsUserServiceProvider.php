<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class ValidationsUserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        App::bind('validations_user', function() {
     		return new \App\ValidationsUser;
     	});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class ValidationsMusicServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
     	App::bind('validations_music', function() {
     		return new \App\ValidationsMusic;
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

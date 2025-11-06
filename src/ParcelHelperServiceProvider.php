<?php

namespace Softrang\ParcelHelper;

use Illuminate\Support\ServiceProvider;

class ParcelHelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('parcel-helper', function () {
            return new ParcelHelper();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/parcel-helper.php' => config_path('parcel-helper.php'),
        ]);
    }
}

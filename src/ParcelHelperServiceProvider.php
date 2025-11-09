<?php


namespace Softrang\ParcelHelper;


use Illuminate\Support\ServiceProvider;


class ParcelHelperServiceProvider extends ServiceProvider
{
public function boot()
{
// Publish config
$this->publishes([
__DIR__ . '/../config/parcel-helper.php' => config_path('parcel-helper.php'),
], 'parcel-helpar');
}


public function register()
{
$this->mergeConfigFrom(__DIR__ . '/../config/parcel-helper.php', 'parcel-helper');


$this->app->singleton(ParcelHelper::class, function ($app) {
$cfg = $app['config']->get('parcel-helper', []);
return new ParcelHelper([
'base_url' => $cfg['base_url'] ?? null,
'api_key' => $cfg['api_key'] ?? null,
'secret_key' => $cfg['secret_key'] ?? null,
]);
});


// Optionally bind a short alias
$this->app->alias(ParcelHelper::class, 'parcel-helper');
}
}
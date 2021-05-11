<?php

namespace Larapress\LiveStream\Providers;

use Illuminate\Support\ServiceProvider;
use Larapress\LiveStream\Commands\LiveStreamCreateProductType;
use Larapress\LiveStream\Services\LiveStream\ILiveStreamService;
use Larapress\LiveStream\Services\LiveStream\LiveStreamService;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ILiveStreamService::class, LiveStreamService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'larapress');
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');

        $this->publishes([
            __DIR__.'/../../config/livestream.php' => config_path('larapress/livestream.php'),
        ], ['config', 'larapress', 'larapress-livestream']);

        if ($this->app->runningInConsole()) {
            $this->commands([
                LiveStreamCreateProductType::class,
            ]);
        }
    }
}

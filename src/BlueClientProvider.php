<?php

namespace BlueClient;

use BlueClient\Application\ApiDataProvider;
use BlueClient\Application\ClientFactory;
use BlueClient\Controller\PanelController;
use Illuminate\Support\ServiceProvider;

/**
 * Class BlueClientProvider
 * @package BlueClient
 */
class BlueClientProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'blue');
        $this->publishes([__DIR__ . '/../config/blueclient.php' => config_path('blueconfig.php')]);
    }

    public function register()
    {
        $this->app->make(PanelController::class);
        $this->app->bind(PanelController::class, function ($app) {
            return new PanelController($app->make(ApiDataProvider::class));
        });
        $this->app->bind(ApiDataProvider::class, function ($app) {
            return new ApiDataProvider(ClientFactory::createFromConfig());
        });
    }
}
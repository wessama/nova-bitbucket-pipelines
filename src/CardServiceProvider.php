<?php

namespace WessamA\NovaBitbucketPipelines;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class CardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        $this->publishes([
            __DIR__.'/../config/nova-bitbucket-pipelines.php' => config_path('nova-bitbucket-pipelines.php'),
        ], 'config');

        Nova::serving(function (ServingNova $event) {
            Nova::script('pipelines', __DIR__ . '/../dist/js/card.js');
            Nova::style('pipelines', __DIR__ . '/../dist/css/card.css');
        });
    }

    /**
     * Register the card's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->prefix('nova-vendor/wessama/nova-bitbucket-pipelines')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/nova-bitbucket-pipelines.php', 'nova-bitbucket-pipelines'
        );
    }
}

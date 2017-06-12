<?php

namespace Willypuzzle\Kendo;

use Illuminate\Support\ServiceProvider;
use Willypuzzle\Kendo\Classes\Grid\Main;

use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;


class KendoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/kendo_grid.php.php', 'kendo_grid');

        $this->publishes([
            __DIR__ . '/config/kendo_grid.php' => config_path('kendo_grid.php'),
        ], 'kendo_grid');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerKendoGrid();
    }

    /**
     * Register the authenticator services.
     *
     * @return void
     */
    protected function registerKendoGrid()
    {
        $this->app->singleton('kendo_grid.fractal', function () {
            $fractal = new Manager;
            $config  = $this->app['config'];
            $request = $this->app['request'];

            $includesKey = $config->get('kendo_grid.fractal.includes', 'include');
            if ($request->get($includesKey)) {
                $fractal->parseIncludes($request->get($includesKey));
            }

            $serializer = $config->get('kendo_grid.fractal.serializer', DataArraySerializer::class);
            $fractal->setSerializer(new $serializer);

            return $fractal;
        });

        $this->app->alias('willypuzzle.kendo.grid', Main::class);
        $this->app->singleton('willypuzzle.kendo.grid', function ($app) {
            return new Main($app);
        });

        $this->registerAliases();
    }

    /**
     * Create aliases for the dependency.
     */
    protected function registerAliases()
    {
        if (class_exists('Illuminate\Foundation\AliasLoader')) {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('KendoGrid', \Willypuzzle\Kendo\Facades\Grid::class);
        }
    }
}

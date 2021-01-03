<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Ragebee\Fishpond\Fishpond;
use Ragebee\LaravelFishpond\ConnectionFactory as AdapterFactory;
use Ragebee\LaravelFishpond\FishpondFactory;

class FishpondServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAdapterFactory();
        $this->registerFishpondFactory();
    }

    /**
     * Register the adapter factory class.
     *
     * @return void
     */
    protected function registerAdapterFactory()
    {
        $this->app->singleton('fishpond.adapterfactory', function () {
            return new AdapterFactory();
        });

        $this->app->alias('fishpond.adapterfactory', AdapterFactory::class);
    }

    /**
     * Register the fishpond factory class.
     *
     * @return void
     */
    protected function registerFishpondFactory()
    {
        $this->app->singleton('fishpond.factory', function (Container $app) {
            $adapter = $app['fishpond.adapterfactory'];

            return new FishpondFactory($adapter);
        });

        $this->app->alias('fishpond.factory', FishpondFactory::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'fishpond.adapterfactory',
            'fishpond.factory',
        ];
    }
}

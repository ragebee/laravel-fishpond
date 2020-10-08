<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Ragebee\Fishpond\Fishpond;
use Ragebee\Fishpond\FishpondInterface;
use Ragebee\LaravelFishpond\Adapters\ConnectionFactory as AdapterFactory;
use Ragebee\LaravelFishpond\FishpondFactory;
use Ragebee\LaravelFishpond\FishpondManager;

class FishpondServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath($raw = __DIR__ . '/../config/fishpond.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('fishpond.php')]);
        }

        $this->mergeConfigFrom($source, 'fishpond');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAdapterFactory();
        $this->registerFishpondFactory();
        $this->registerManager();
        $this->registerBindings();
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
     * Register the manager class.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('fishpond', function (Container $app) {
            $config = $app['config'];
            $factory = $app['fishpond.factory'];

            return new FishpondManager($config, $factory);
        });

        $this->app->alias('fishpond', FishpondManager::class);
    }

    /**
     * Register the bindings.
     *
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind('fishpond.connection', function (Container $app) {
            $manager = $app['fishpond'];

            return $manager->connection();
        });

        $this->app->alias('fishpond.connection', Fishpond::class);
        $this->app->alias('fishpond.connection', FishpondInterface::class);
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
            'fishpond',
            'fishpond.connection',
        ];
    }
}

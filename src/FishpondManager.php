<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Ragebee\Fishpond\PluginInterface;
use Ragebee\LaravelFishpond\FishpondFactory;

class FishpondManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var \Ragebee\LaravelFishpond\FishpondFactory
     */
    protected $factory;

    protected $plugins = [];

    /**
     * Create a new flysystem manager instance.
     *
     * @param \Illuminate\Contracts\Config\Repository    $config
     * @param \Ragebee\LaravelFishpond\FishpondFactory $factory
     *
     * @return void
     */
    public function __construct(Repository $config, FishpondFactory $factory)
    {
        $this->config = $config;
        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return \Ragebee\Fishpond\FishpondInterface
     */
    protected function createConnection(array $config)
    {
        $connection = $this->factory->make($config, $this);

        foreach ($this->plugins as $plugin) {
            $connection->addPlugin($plugin);
        }

        return $connection;
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName()
    {
        return 'fishpond';
    }

    /**
     * Get the configuration for a connection.
     *
     * @param string|null $name
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getConnectionConfig(string $name = null)
    {
        $name = $name ?: $this->getDefaultConnection();

        $connections = $this->config->get($this->getConfigName() . '.connections');

        if (!is_array($config = Arr::get($connections, strtolower($name))) && !$config) {
            throw new InvalidArgumentException("Adapter [$name] not configured.");
        }

        $config['name'] = $name;

        return $config;
    }

    /**
     * Get the factory instance.
     *
     * @return \Ragebee\LaravelFishpond\FishpondFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    public function addPlugin(PluginInterface $plugin)
    {
        $this->plugins[] = $plugin;
    }

    /**
     * Set the connection conifg.
     *
     * @param string $name
     *
     * @return void
     */
    public function setConnectionConfig(string $name, $key, $value)
    {
        $name = strtolower($name);

        $name = $name ?: $this->getDefaultConnection();

        if (!$name) {
            throw new InvalidArgumentException("$name not configured.");
        }

        $this->config->set($this->getConfigName() . '.connections.' . $name . '.' . $key, $value);
    }
}

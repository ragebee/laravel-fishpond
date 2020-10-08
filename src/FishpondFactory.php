<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond;

use Illuminate\Support\Arr;
use Ragebee\Fishpond\Fishpond;
use Ragebee\LaravelFishpond\Adapters\ConnectionFactory as AdapterFactory;
use Ragebee\LaravelFishpond\FishpondManager;

class FishpondFactory
{
    /**
     * The adapter factory instance.
     *
     * @var \Ragebee\LaravelFishpond\Adapters\ConnectionFactory
     */
    protected $adapter;

    /**
     * Create a new filesystem factory instance.
     *
     * @param \Ragebee\LaravelFishpond\Adapters\ConnectionFactory $adapter
     *
     * @return void
     */
    public function __construct(AdapterFactory $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Make a new fishpond instance.
     *
     * @param array                                      $config
     * @param \Ragebee\LaravelFishpond\FishpondManager $manager
     *
     * @return \Ragebee\Fishpond\FishpondInterface
     */
    public function make(array $config, FishpondManager $manager)
    {
        $adapter = $this->createAdapter($config);
        $options = $this->getOptions($config);

        return new Fishpond($adapter, $options);
    }

    /**
     * Establish an adapter connection.
     *
     * @param array $config
     *
     * @return \Ragebee\Fishpond\AdapterInterface
     */
    public function createAdapter(array $config)
    {
        return $this->adapter->make($config);
    }

    /**
     * Get the fishpond options.
     *
     * @param array $config
     *
     * @return array|null
     */
    protected function getOptions(array $config)
    {
        $options = [];

        // if ($somevalue = Arr::get($config, 'somevalue')) {
        //     $options['somevalue'] = $somevalue;
        // }

        return $options;
    }

    /**
     * Get the adapter factory instance.
     *
     * @return \Ragebee\LaravelFishpond\Adapters\ConnectionFactory
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}

<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond;

use Illuminate\Support\Arr;
use Ragebee\Fishpond\Fishpond;
use Ragebee\LaravelFishpond\ConnectionFactory as AdapterFactory;

class FishpondFactory
{
    /**
     * The adapter factory instance.
     *
     * @var \Ragebee\LaravelFishpond\ConnectionFactory
     */
    protected $adapter;

    /**
     * Create a new filesystem factory instance.
     *
     * @param \Ragebee\LaravelFishpond\ConnectionFactory $adapter
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
     * @param array $confi
     *
     * @return \Ragebee\Fishpond\FishpondInterface
     */
    public function make(array $config)
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
     * @return \Ragebee\LaravelFishpond\ConnectionFactory
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}

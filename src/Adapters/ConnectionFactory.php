<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond\Adapters;

use InvalidArgumentException;
use Ragebee\LaravelFishpond\Adapters\Cq9SeamlessConnector;
use Ragebee\LaravelFishpond\Adapters\IcgSeamlessConnector;
use Ragebee\LaravelFishpond\Adapters\JlSeamlessConnector;

class ConnectionFactory
{
    /**
     * Establish an adapter connection.
     *
     * @param array $config
     *
     * @return \Ragebee\Fishpond\AdapterInterface
     */
    public function make(array $config)
    {
        return $this->createConnector($config)->connect($config);
    }

    /**
     * Create a connector instance based on the configuration.
     *
     * @param array $config
     *
     * @throws \InvalidArgumentException
     *
     * @return \GrahamCampbell\Manager\ConnectorInterface
     */
    public function createConnector(array $config)
    {
        if (!isset($config['driver'])) {
            throw new InvalidArgumentException('A driver must be specified.');
        }

        switch ($config['driver']) {
            case 'cq9seamless':
                return new Cq9SeamlessConnector();
            case 'jlseamless':
                return new JlSeamlessConnector();
            case 'icgseamless':
                return new IcgSeamlessConnector();
        }

        throw new InvalidArgumentException("Unsupported driver [{$config['driver']}].");
    }
}

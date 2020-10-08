<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond\Adapters;

use InvalidArgumentException;
use Ragebee\LaravelFishpond\Adapters\Cq9SlotSeamlessConnector;
use Ragebee\LaravelFishpond\Adapters\DragoonSoftConnector;
use Ragebee\LaravelFishpond\Adapters\IaEsConnector;
use Ragebee\LaravelFishpond\Adapters\S182SbConnector;
use Ragebee\LaravelFishpond\Adapters\SuperDiamondConnector;

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
            case 'dragoonsoft':
                return new DragoonSoftConnector();
            case 'superdiamond':
                return new SuperDiamondConnector();
            case 's182sb':
                return new S182SbConnector();
            case 'iaes':
                return new IaEsConnector();
            case 'dsslotseamless':
                return new DsSlotSeamlessConnector();
            case 'cq9slotseamless':
                return new Cq9SlotSeamlessConnector();
            case 'nwbg':
                return new NwBgConnector();
        }

        throw new InvalidArgumentException("Unsupported driver [{$config['driver']}].");
    }
}

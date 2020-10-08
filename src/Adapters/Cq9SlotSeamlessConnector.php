<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond\Adapters;

use FishpondServices\Cq9SlotSeamless\Cq9SlotSeamlessAdapter;
use FishpondServices\Cq9SlotSeamless\Cq9SlotSeamlessClient;
use GrahamCampbell\Manager\ConnectorInterface;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class Cq9SlotSeamlessConnector implements ConnectorInterface
{
    /**
     * Establish an adapter connection.
     *
     * @param string[] $config
     *
     * @return \FishpondServices\Cq9SlotSeamless\Cq9SlotSeamlessAdapter
     */
    public function connect(array $config)
    {
        $args = $this->getArgs($config);
        $client = $this->getClient($args);

        return $this->getAdapter($client);
    }

    /**
     * Get the authentication data.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return string[]
     */
    protected function getArgs(array $config)
    {
        if (!Arr::has($config, ['api_key'])) {
            throw new InvalidArgumentException('The CQ9 Slot Seamless connector requires authentication.');
        }

        if (!array_key_exists('api_url', $config)) {
            throw new InvalidArgumentException('The CQ9 Slot Seamless connector requires api_url.');
        }

        return [
            'api_url' => $config['api_url'],
            'client' => data_get($config, 'client'),
            'credentials' => Arr::only($config, ['api_key']),
        ];
    }

    /**
     * Get the client.
     *
     * @param string[] $args
     *
     * @return \FishpondServices\Cq9SlotSeamless\Cq9SlotSeamlessClient
     */
    protected function getClient(array $args)
    {
        return new Cq9SlotSeamlessClient($args);
    }

    /**
     * Get the Dragoon Soft adapter.
     *
     * @param \FishpondServices\Cq9SlotSeamless\Cq9SlotSeamlessClient $client
     *
     * @return \FishpondServices\Cq9SlotSeamless\Cq9SlotSeamlessAdapter
     */
    protected function getAdapter(Cq9SlotSeamlessClient $client)
    {
        return new Cq9SlotSeamlessAdapter($client);
    }
}

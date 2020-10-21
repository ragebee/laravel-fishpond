<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond\Adapters;

use GrahamCampbell\Manager\ConnectorInterface;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Ragebee\Provider\Cq9Seamless\Cq9SeamlessAdapter;
use Ragebee\Provider\Cq9Seamless\Cq9SeamlessClient;

class Cq9SeamlessConnector implements ConnectorInterface
{
    /**
     * Establish an adapter connection.
     *
     * @param string[] $config
     *
     * @return \Ragebee\Provider\Cq9Seamless\Cq9SeamlessAdapter
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
     * @return \Ragebee\Provider\Cq9Seamless\Cq9SeamlessClient
     */
    protected function getClient(array $args)
    {
        return new Cq9SeamlessClient($args);
    }

    /**
     * Get the Dragoon Soft adapter.
     *
     * @param \Ragebee\Provider\Cq9Seamless\Cq9SeamlessClient $client
     *
     * @return \Ragebee\Provider\Cq9Seamless\Cq9SeamlessAdapter
     */
    protected function getAdapter(Cq9SlotSeamlessClient $client)
    {
        return new Cq9SeamlessAdapter($client);
    }
}

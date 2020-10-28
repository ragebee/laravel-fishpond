<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond\Adapters;

use GrahamCampbell\Manager\ConnectorInterface;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Ragebee\Provider\JlSeamless\JlSeamlessAdapter;
use Ragebee\Provider\JlSeamless\JlSeamlessClient;

class JlSeamlessConnector implements ConnectorInterface
{
    public function connect(array $config)
    {
        $args = $this->getArgs($config);
        $client = $this->getClient($args);

        return $this->getAdapter($client);
    }

    protected function getArgs(array $config)
    {
        if (!Arr::has($config, ['agent_key'])) {
            throw new InvalidArgumentException('The Jl Seamless connector requires agent_key.');
        }

        if (!Arr::has($config, ['agent_id'])) {
            throw new InvalidArgumentException('The Jl Seamless connector requires agent_id.');
        }

        if (!array_key_exists('api_url', $config)) {
            throw new InvalidArgumentException('The Jl Seamless connector requires api_url.');
        }

        return [
            'api_url' => $config['api_url'],
            'client' => data_get($config, 'client'),
            'credentials' => Arr::only($config, ['agent_key', 'agent_id']),
        ];
    }

    protected function getClient(array $args)
    {
        return new JlSeamlessClient($args);
    }

    protected function getAdapter(JlSeamlessClient $client)
    {
        return new JlSeamlessAdapter($client);
    }
}

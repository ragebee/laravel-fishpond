<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond\Adapters;

use GrahamCampbell\Manager\ConnectorInterface;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Ragebee\Provider\IcgSeamless\IcgSeamlessAdapter;
use Ragebee\Provider\IcgSeamless\IcgSeamlessClient;

class IcgSeamlessConnector implements ConnectorInterface
{
    public function connect(array $config)
    {
        $args = $this->getArgs($config);
        $client = $this->getClient($args);

        return $this->getAdapter($client);
    }

    protected function getArgs(array $config)
    {
        if (!Arr::has($config, ['token'])) {
            throw new InvalidArgumentException('The Jl Seamless connector requires token.');
        }

        return [
            'api_url' => $config['api_url'],
            'client' => data_get($config, 'client'),
            'credentials' => Arr::only($config, ['token']),
        ];
    }

    protected function getClient(array $args)
    {
        return new IcgSeamlessClient($args);
    }

    protected function getAdapter(IcgSeamlessClient $client)
    {
        return new IcgSeamlessAdapter($client);
    }
}

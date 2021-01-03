<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Ragebee\Fishpond\OperatorConstant;

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
        return $this->connect($config);
    }

    /**
     * Establish an adapter connection.
     *
     * @param array $config
     *
     * @throws \InvalidArgumentException
     *
     * @return \Ragebee\Fishpond\AdapterInterface
     */
    public function connect(array $config)
    {
        if (!isset($config['driver'])) {
            throw new InvalidArgumentException('A driver must be specified.');
        }

        $args = $this->getArgs($config);

        $clientName = "Ragebee\\Provider\\" . ($name = ucfirst(Str::camel($config['driver']))) . "\\" . $name . "Client";
        $adapterName = "Ragebee\\Provider\\" . $name . "\\" . $name . "Adapter";

        $client = new $clientName($args);
        return new $adapterName($client);
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
        $adapterName = "Ragebee\\Provider\\" . ($name = ucfirst(Str::camel($config['driver']))) . "\\" . $name . "Adapter";

        foreach ($adapterName::getRequiredCredentialsKeys() as $requiredCredentialsKey) {
            if (!Arr::has($config, [$requiredCredentialsKey])) {
                throw new InvalidArgumentException("The [{$config['driver']}] connector requires " . $requiredCredentialsKey . ".");
            }
        }

        return [
            'client' => data_get($config, OperatorConstant::CONFIG_KEY_CLIENT),
            'config' => Arr::except($config, [OperatorConstant::CONFIG_KEY_CLIENT]),
        ];
    }
}

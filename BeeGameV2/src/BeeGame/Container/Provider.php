<?php

namespace BeeGame\Container;

use Pimple\ServiceProviderInterface;

abstract class Provider implements ServiceProviderInterface
{
    protected $callbacks = [];

    public function __get($property)
    {
        if (array_key_exists($property, $this->callbacks)) {
            return $this->callbacks[ $property ];
        }
        return null;
    }

    protected function createCallback($identifier, callable $callback)
    {
        if (array_key_exists($identifier, $this->callbacks)) {
            throw new \InvalidArgumentException(
                sprintf(
                    __(
                        'Invalid identifier: %s has already been set.',
                        'app'
                    ),
                    $identifier
                )
            );
        }
        $this->callbacks[ $identifier ] = $callback;
        return $callback;
    }
}

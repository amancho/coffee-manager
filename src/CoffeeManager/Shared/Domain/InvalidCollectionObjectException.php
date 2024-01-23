<?php

namespace CoffeeManager\Shared\Domain;

class InvalidCollectionObjectException extends \Exception
{

    /**
     * @param mixed $current
     * @param string $expected
     */
    public function __construct(mixed $current, string $expected)
    {
        parent::__construct(
            sprintf('"%s" is not a valid object for collection. Expected "%s"', get_class($current), $expected)
        );
    }
}
<?php
namespace CoffeeManager\Shared\Domain\ValueObject;

abstract class BooleanValueObject
{
    protected bool $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function value(): bool
    {
        return $this->value;
    }

    public function isTrue(): bool
    {
        return $this->value() == true;
    }

    public function isFalse(): bool
    {
        return $this->value() == false;
    }
}
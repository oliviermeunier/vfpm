<?php

namespace Fulll\Domain\Model;

class PlateNumber
{

    private string $value;

    public function __construct(string $value)
    {
        if (!preg_match('/^[A-Z]{2}-\d{3}-[A-Z]{2}$/', $value)) {
            throw new \InvalidArgumentException('Not valid plate number');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(PlateNumber $plateNumber): bool
    {
        return $plateNumber->getValue() === $this->value;
    }
}

<?php 

namespace Fulll\Domain\Model;

class PlateNumber {

    public function __construct(private string $value)
    {}
    
    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(PlateNumber $plateNumber): bool
    {
        return $plateNumber->getValue() === $this->value;
    }
}
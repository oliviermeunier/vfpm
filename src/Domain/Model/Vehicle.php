<?php 

namespace Fulll\Domain\Model;

class Vehicle
{
    public function __construct(private string $id)
    {}

    public function getId(): string
    {
        return $this->id;
    }
}
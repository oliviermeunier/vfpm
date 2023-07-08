<?php

declare(strict_types=1);

namespace Fulll\Domain\Shared\ValueObject;

abstract class AggregateRootId
{
    /** @var string  */
    protected string $uuid;

    /**
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        if (!preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid)) {
            throw new \InvalidArgumentException('Not valid UUID');
        }

        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->uuid;
    }

    /**
     * @param AggregateRootId $id
     * @return bool
     */
    public function equals(AggregateRootId $id)
    {
        return $this->uuid === $id->getValue();
    }
}

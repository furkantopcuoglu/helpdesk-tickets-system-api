<?php

namespace Common\Domain\DataTransferObject;

/** @phpstan-consistent-constructor */
class TraceableDataTransferObject extends \Spatie\DataTransferObject\DataTransferObject
{
    private array $dtoParameters;

    public function __construct(array $parameters = [])
    {
        $this->dtoParameters = $parameters;

        parent::__construct($parameters);
    }

    public function hasParameter(string $key): bool
    {
        return array_key_exists($key, $this->dtoParameters);
    }

    public static function fromArray(array $parameters = []): static
    {
        return new static($parameters);
    }

    public function addParameters(array $parameters = []): static
    {
        return new static(array_merge($parameters, $this->dtoParameters));
    }

    public function getOptions(): array
    {
        return array_filter($this->dtoParameters, function ($value) {
            return null !== $value;
        });
    }
}

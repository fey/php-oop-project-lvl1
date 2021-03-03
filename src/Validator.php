<?php

namespace Hexlet\Validator;

class Validator
{
    private array $customValidators = [];

    public function string(): StringSchema
    {
        return new StringSchema($this->customValidators['string'] ?? []);
    }

    public function number(): NumberSchema
    {
        return new NumberSchema($this->customValidators['number'] ?? []);
    }

    public function array(): ArraySchema
    {
        return new ArraySchema($this->customValidators['array'] ?? []);
    }

    public function addValidator(string $type, string $name, callable $fn): self
    {
        $this->customValidators[$type][$name] = $fn;

        return $this;
    }
}

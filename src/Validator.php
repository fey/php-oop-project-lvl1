<?php

namespace Hexlet\Validator;

class Validator
{
    private array $customValidators = [];

    public function string(): StringSchema
    {
        return new StringSchema($this->getCustomValidators('string'));
    }

    public function number(): NumberSchema
    {
        return new NumberSchema($this->getCustomValidators('number'));
    }

    public function array(): ArraySchema
    {
        return new ArraySchema($this->getCustomValidators('array'));
    }

    public function addValidator(string $type, string $name, callable $fn): self
    {
        $this->customValidators[$type][$name] = $fn;

        return $this;
    }

    private function getCustomValidators(string $type): array
    {
        return $this->customValidators[$type] ?? [];
    }
}

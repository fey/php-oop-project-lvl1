<?php

namespace Hexlet\Validator;

/**
 * required – требуется тип данных array
 * sizeof – длина массива равна указанной
 */
class ArraySchema implements Schema
{
    /** @var callable[]  */
    private array $validators = [];
    private array $customValidators = [];

    public function __construct(array $customValidators)
    {
        $this->customValidators = $customValidators;
    }

    public function required(): self
    {
        $this->validators['required'] = fn($value) => is_array($value);

        return $this;
    }

    public function sizeof(int $size): self
    {
        $this->validators['sizeof'] = fn($value) => count($value) === $size;

        return $this;
    }

    public function isValid($value): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Schema[] $schemas
     * @return $this
     */
    public function shape(array $schemas): self
    {
        $this->validators['shape'] = function ($value) use ($schemas): bool {
            foreach ($schemas as $key => $schema) {
                if (!$schema->isValid($value[$key])) {
                    return false;
                }
            }

            return true;
        };

        return $this;
    }

    public function test(string $name, ...$args): self
    {
        $this->validators[$name] = function ($value) use ($name, $args) {
            $validator = $this->customValidators[$name];

            return $validator($value, ...$args);
        };

        return $this;
    }
}

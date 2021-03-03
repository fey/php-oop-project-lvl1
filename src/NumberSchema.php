<?php

namespace Hexlet\Validator;

/**
 * required – любое число включая ноль
 * positive – положительное число
 * range – диапазон в который должны попадать числа включая границы
 */
class NumberSchema implements Schema
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
        $this->validators['required'] = fn($value) => is_numeric($value);

        return $this;
    }

    public function positive(): self
    {
        $this->validators['positive'] = fn($value) => $value === null || $value > 0;

        return $this;
    }

    public function range($min, $max): self
    {
        $this->validators['range'] = fn($value) => ($min <= $value) && ($value <= $max);

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

    public function test(string $name, ...$args): self
    {
        $this->validators[$name] = function ($value) use ($name, $args) {
            $validator = $this->customValidators[$name];

            return $validator($value, ...$args);
        };

        return $this;
    }
}

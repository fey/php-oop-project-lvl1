<?php

namespace Hexlet\Validator;

/**
 * required – любое число включая ноль
 * positive – положительное число
 * range – диапазон в который должны попадать числа включая границы
 */
class NumberSchema implements Schema
{
    private ?bool $required = null;
    private ?bool $positive = null;
    private ?array $range = null;

    public function required(): self
    {
        $this->required = true;

        return $this;
    }

    public function positive(): self
    {
        $this->positive = true;

        return $this;
    }

    public function range($min, $max): self
    {
        $this->range = [$min, $max];

        return $this;
    }

    public function isValid($value): bool
    {
        if ($this->required !== null) {
            if (!is_numeric($value)) {
                return false;
            }
        }

        if ($value === null) {
            return true;
        }

        if ($this->positive !== null) {
            if (0 > $value) {
                return false;
            }
        }

        if ($this->range !== null) {
            [$min, $max] = $this->range;

            if ($value < $min || $value > $max) {
                return false;
            }
        }

        return true;
    }
}

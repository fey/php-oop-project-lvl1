<?php

namespace Hexlet\Validator;

/**
 * required – требуется тип данных array
 * sizeof – длина массива равна указанной
 */
class ArraySchema implements Schema
{
    private ?bool $required = null;
    private ?int $size = null;
    private ?array $shape = null;

    public function required(): self
    {
        $this->required = true;
        return $this;
    }

    public function sizeof(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function isValid($value): bool
    {
        if ($this->required !== null) {
            if (!is_array($value)) {
                return false;
            }
        }

        if ($this->size !== null) {
            if (\count($value) !== $this->size) {
                return false;
            }
        }

        if ($this->shape !== null) {
            foreach ($this->shape as $key => $schema) {
                if (!$schema->isValid($value[$key])) {
                    return false;
                }
            }
        }

        return true;
    }

    public function shape(array $array): self
    {
        $this->shape = $array;

        return $this;
    }
}

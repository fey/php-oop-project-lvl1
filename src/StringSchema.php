<?php

namespace Hexlet\Validator;


/**
 * required – любая непустая строка
 * minLength – строка равна или длиннее указанного числа
 * contains – строка содержит определённую подстроку
 */
class StringSchema
{
    private ?bool $required = null;
    private ?string $substring = null;
    private ?int $minLength = null;

    public function required(): self
    {
        $this->required = true;

        return $this;
    }

    public function contains($substring): self
    {
        $this->substring = $substring;

        return $this;
    }

    public function minLength(int $minLength): self
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function isValid($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        if ($this->required !== null) {
            if ($value === '') {
                return false;
            }
        }

        if ($this->minLength !== null) {
            if (mb_strlen($value) < $this->minLength) {
                return false;
            }
        }

        if ($this->substring !== null) {
            if (mb_strpos($value, $this->substring) === false) {
                return false;
            }
        }

        return true;
    }
}

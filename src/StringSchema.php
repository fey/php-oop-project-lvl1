<?php

namespace Hexlet\Validator;

/**
 * required – любая непустая строка
 * minLength – строка равна или длиннее указанного числа
 * contains – строка содержит определённую подстроку
 */
class StringSchema implements Schema
{
    /** @var callable[]  */
    private array $validators = [];
    /** @var callable[]  */
    private array $customValidators;

    public function __construct(array $customValidators)
    {
        $this->customValidators = $customValidators;
    }

    public function required(): self
    {
        $this->validators['required'] = function ($value): bool {
            return is_string($value) && $value !== '';
        };

        return $this;
    }

    public function contains($substring): self
    {
        $this->validators['contains'] = function ($value) use ($substring): bool {
            return mb_strpos($value, $substring) !== false;
        };

        return $this;
    }

    public function minLength(int $minLength): self
    {
        $this->validators['minLength'] = function ($value) use ($minLength): bool {
            return mb_strlen($value) >= $minLength;
        };

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

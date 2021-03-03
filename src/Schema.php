<?php

namespace Hexlet\Validator;

interface Schema
{
    public function isValid($value): bool;

    public function test(string $name, ...$args): self;
}

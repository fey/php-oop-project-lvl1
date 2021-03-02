<?php

namespace Hexlet\Validator;

interface Schema
{
    public function isValid($value): bool;
}

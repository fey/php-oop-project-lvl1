<?php

namespace Hexlet\Validator;

class Validator
{
    public function string(): StringSchema
    {
        return new StringSchema();
    }

    public function number(): Numbers
    {
        return new Numbers();
    }

    public function array(): ArraySchema
    {
        return new ArraySchema();
    }
}

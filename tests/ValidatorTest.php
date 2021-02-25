<?php

namespace Hexlet\Validator\Tests;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testString(): void
    {
        $schema = $this->validator->string();

        $this->assertTrue($schema->isValid('')); // true

        $schema->required();
        $this->assertTrue($schema->isValid('what does the fox say')); // true
        $this->assertTrue($schema->isValid('hexlet')); // true
        $this->assertFalse($schema->isValid(null)); // false
        $this->assertFalse($schema->isValid('')); // false

        $schema->minLength(8);

        $this->assertTrue($schema->isValid('what does the fox say'));
        $this->assertFalse($schema->isValid('google'));

        $this->assertTrue($schema->contains('what')->isValid('what does the fox say')); // true
        $this->assertFalse($schema->contains('whatthe')->isValid('what does the fox say')); // faFalse
    }

    public function testNumbers()
    {
        $schema = $this->validator->number();

        $this->assertEquals(true, $schema->isValid(null)); // true

        $schema->required();

        $this->assertEquals(false, $schema->isValid(null)); // false
        $this->assertEquals(true, $schema->isValid(7)); // true

        $schema->positive()->isValid(10); // true

        $schema->range(-5, 5);

        $this->assertEquals(false, $schema->isValid(-3)); // false
        $this->assertEquals(true, $schema->isValid(5)); // true
    }
}

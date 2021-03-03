<?php

namespace Hexlet\Validator\Tests;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

use function \str_starts_with;

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

    public function testNumbers(): void
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

    public function testArray(): void
    {
        $schema = $this->validator->array();

        $this->assertEquals(true, $schema->isValid(null)); // false @todo @fixme

        $schema = $schema->required();

        $this->assertEquals(true, $schema->isValid([])); // true
        $this->assertEquals(true, $schema->isValid(['hexlet'])); // true

        $schema->sizeof(2); // true

        $this->assertEquals(false, $schema->isValid(['hexlet'])); // false
        $this->assertEquals(true, $schema->isValid(['hexlet', 'code-basics'])); // true
    }

    public function testShape(): void
    {
        $schema = $this->validator->array();

        // Позволяет описывать валидацию для ключей массива
        $schema->shape([
            'name' => $this->validator->string()->required(),
            'age' => $this->validator->number()->positive(),
        ]);

        $this->assertEquals(true, $schema->isValid(['name' => 'kolya', 'age' => 100])); // true
        $this->assertEquals(true, $schema->isValid(['name' => 'maya', 'age' => null])); // true
        $this->assertEquals(false, $schema->isValid(['name' => '', 'age' => null])); // false
        $this->assertEquals(false, $schema->isValid(['name' => 'ada', 'age' => -5])); // false
    }

    public function testAddValidator(): void
    {
        $fn = fn($value, $start) => str_starts_with($value, $start);
        // Метод добавления новых валидаторов
        // addValidator($type, $name, $fn)
        $this->validator->addValidator('string', 'startWith', $fn);

        // Новые валидаторы вызываются через метод test
        $schema = $this->validator->string()->test('startWith', 'H');
        $this->assertEquals(false, $schema->isValid('exlet')); // false
        $this->assertEquals(true, $schema->isValid('Hexlet')); // true

        $fn = fn($value, $min) => $value >= $min;
        $this->validator->addValidator('number', 'min', $fn);

        $schema = $this->validator->number()->test('min', 5);
        $this->assertEquals(false, $schema->isValid(4)); // false
        $this->assertEquals(true, $schema->isValid(6)); // true
    }
}

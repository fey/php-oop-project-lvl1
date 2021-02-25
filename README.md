### Hexlet tests and linter status:
[![Actions Status](https://github.com/fey/php-oop-project-lvl1/workflows/hexlet-check/badge.svg)](https://github.com/fey/php-oop-project-lvl1/actions)
[![Maintainability](https://api.codeclimate.com/v1/badges/fc3be5da2d90a7701ac9/maintainability)](https://codeclimate.com/github/fey/php-oop-project-lvl1/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/fc3be5da2d90a7701ac9/test_coverage)](https://codeclimate.com/github/fey/php-oop-project-lvl1/test_coverage)

### Description
Data validator is a library that can be used to check the correctness of any data.

### Prequesites

* PHP >=7.4
* Composer

### Commands
```shell
$ make start
$ make test
```

### Usage

```php
<?php

use Hexlet\Validator\Validator;

$v = new \Hexlet\Validator\Validator();

// строки
$schema = $v->required()->string();

$schema->isValid('what does the fox say'); // true
$schema->isValid(''); // false

// числа
$schema = $v->required()->number()->positive();

$schema->isValid(-10); // false
$schema->isValid(10); // true

// массив с поддержкой проверки структуры
$schema = $v->array()->sizeof(2)->shape([
    'name' => $v->string()->required(),
    'age' => $v->number()->positive(),
]);

$schema->isValid(['name' => 'kolya', 'age' => 100]); // true
$schema->isValid(['name' => '', 'age' => null]); // false

// Добавление нового валидатора
$fn = fn($value, $start) => str_starts_with($value, $start);
$v->addValidator('string', 'startWith', $fn);

$schema = $v->string()->test('startWith', 'H');

$schema->isValid('exlet'); // false
$schema->isValid('Hexlet'); // true
```
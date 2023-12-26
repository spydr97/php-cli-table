<?php

global $mock_data;

use Spydr97\PhpCliTable\Builders\FieldBuilder;
use Spydr97\PhpCliTable\CliTableBuilder;

require_once __DIR__ . '/../vendor/autoload.php';
require_once "000-data.php";

$fields = [
    (new FieldBuilder())
        ->setKey('todo')
        ->setName('To-do')
        ->build(),
    (new FieldBuilder())
        ->setKey('completed')
        ->setFormatter(function ($datum): string {
            return $datum['completed'] == 1 ? "YES" : "NO";
        })
        ->build(),
];

(new CliTableBuilder())
    ->setData($mock_data)
    ->setFields($fields)
    ->build();

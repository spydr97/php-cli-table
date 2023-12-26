<?php

global $mock_data;

use Spydr97\PhpCliTable\CliTableBuilder;
use Spydr97\PhpCliTable\Constants\FieldConstants;

require_once __DIR__ . '/../vendor/autoload.php';
require_once "000-data.php";

$fields = [
    [
        FieldConstants::FIELD_KEY => 'todo',
        FieldConstants::FIELD_NAME => 'To-do',
    ],
    [
        FieldConstants::FIELD_KEY => 'completed',
        FieldConstants::FIELD_FORMATTER => function ($datum): string {
            return $datum['completed'] == 1 ? "YES" : "NO";
        },
    ],
];

(new CliTableBuilder())
    ->setData($mock_data)
    ->setFields($fields)
    ->build();

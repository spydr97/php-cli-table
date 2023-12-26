<?php

global $mock_data;

use Spydr97\PhpCliTable\CliTableBuilder;
use Spydr97\PhpCliTable\Constants\FieldConstants;
use Spydr97\PhpCliTable\TextColorEnum;

require_once __DIR__ . '/../vendor/autoload.php';
require_once "000-data.php";

$fields = [
    [
        FieldConstants::FIELD_KEY => 'id',
        FieldConstants::FIELD_NAME => 'ID',
    ],
    [
        FieldConstants::FIELD_KEY => 'todo',
        FieldConstants::FIELD_NAME => 'To-do',
    ],
    [
        FieldConstants::FIELD_KEY => 'completed',
        FieldConstants::FIELD_NAME => 'Completed',
        FieldConstants::FIELD_COLUMN_COLOR => function ($datum): TextColorEnum {
            return match ($datum['completed']) {
                'YES' => TextColorEnum::GREEN,
                'NO' => TextColorEnum::RED,
                default => TextColorEnum::WHITE
            };
        },
        FieldConstants::FIELD_FORMATTER => function ($datum): string {
            return $datum['completed'] == 1 ? "YES" : "NO";
        },
    ],
];

(new CliTableBuilder())
    ->setData($mock_data)
    ->setFields($fields)
    ->build();

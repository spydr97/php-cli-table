<?php

use Spydr97\PhpCliTable\CliTableBuilder;
use Spydr97\PhpCliTable\Constants\FieldConstants;
use Spydr97\PhpCliTable\TextColorEnum;

require_once __DIR__ . '/../vendor/autoload.php';

$exclamation_mark = "!";
$data = [
    [
        'id' => 4,
        'todo' => "Contribute code or a monetary donation\nto an " . TextColorEnum::GREEN->value . "open-source" . TextColorEnum::RESET->value . " software project",
        'completed' => false,
    ],
    [
        'id' => 24,
        'todo' => 'Improve touch typing',
        'completed' => false,
    ],
    [
        'id' => 25,
        'todo' => 'Learn PHP',
        'completed' => true,
    ],
];

$fields = [
    [
        FieldConstants::FIELD_KEY => 'id',
        FieldConstants::FIELD_COLUMN_COLOR => TextColorEnum::BLUE,
        FieldConstants::FIELD_HEADER_COLOR => TextColorEnum::DARK_GREY,
    ],
    [
        FieldConstants::FIELD_NAME => 'To-do',
        FieldConstants::FIELD_KEY => 'todo',
        FieldConstants::FIELD_FORMATTER => function ($datum) use ($exclamation_mark): string {
            return $datum['todo'] . $exclamation_mark;
        },
        FieldConstants::FIELD_COLUMN_COLOR => function ($datum, $field): ?TextColorEnum {
            if ($datum[$field[FieldConstants::FIELD_KEY]] == 'Learn PHP!') {
                return TextColorEnum::YELLOW;
            }
            return null;
        },
    ],
    [
        FieldConstants::FIELD_KEY => 'completed',
        FieldConstants::FIELD_FORMATTER => function ($datum): string {
            return $datum['completed'] == 1 ? "YES" : "NO";
        },
        FieldConstants::FIELD_COLUMN_COLOR => function ($datum): TextColorEnum {
            return match ($datum['completed']) {
                'YES' => TextColorEnum::GREEN,
                'NO' => TextColorEnum::RED,
                default => TextColorEnum::WHITE
            };
        },
    ],
];

(new CliTableBuilder())
    ->setData($data)
    ->setFields($fields)
    ->setBorderColor(TextColorEnum::DARK_CYAN)
    ->setShowHeader(true)
    ->build();

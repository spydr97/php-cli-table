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
        'interpolated_colors' => 'Some ' . TextColorEnum::DARK_RED->value . 'RED' . TextColorEnum::RESET->value . ' Text',
    ],
    [
        'id' => 24,
        'todo' => 'Improve touch typing',
        '_color' => TextColorEnum::DARK_BLUE,
    ],
    [
        'id' => 25,
        'todo' => 'Learn PHP',
    ],
];

$fields = [
    [
        FieldConstants::FIELD_KEY => 'id',
        FieldConstants::FIELD_COLUMN_COLOR => TextColorEnum::MAGENTA,
        FieldConstants::FIELD_HEADER_COLOR => TextColorEnum::GREEN,
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
        }
    ],
];

(new CliTableBuilder())
    ->setData($data)
    ->setFields($fields)
    ->setBorderColor(TextColorEnum::DARK_CYAN)
    ->setShowHeader(true)
    ->setEmptyCellPlaceholder('---')
    ->build();

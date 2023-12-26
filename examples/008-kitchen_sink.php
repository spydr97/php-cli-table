<?php

use Spydr97\PhpCliTable\CliTableBuilder;
use Spydr97\PhpCliTable\Constants\FieldConstants;
use Spydr97\PhpCliTable\TextColorEnum;

require_once __DIR__ . '/../vendor/autoload.php';

$smiley_face = " :)";
$data = [
    [
        'id' => 1,
        'first_name' => 'Raina',
        'last_name' => 'Romeo',
        'multi_line' => "Some\nMulti-line\nText",
        'interpolated_colors' => 'Some ' . TextColorEnum::DARK_RED->value . 'RED' . TextColorEnum::RESET->value . ' Text',
    ],
    [
        'id' => 2,
        'first_name' => 'Skye',
        'last_name' => "Newton",
        '_color' => TextColorEnum::DARK_BLUE,
    ],
    [
        'id' => 3,
        'first_name' => 'Harmonia',
        'last_name' => 'Keems',
    ],
];

$fields = [
    [
        FieldConstants::FIELD_NAME => 'First Name',
        FieldConstants::FIELD_KEY => 'first_name',
        FieldConstants::FIELD_COLUMN_COLOR => TextColorEnum::MAGENTA,
        FieldConstants::FIELD_HEADER_COLOR => TextColorEnum::GREEN,
    ],
    [
        FieldConstants::FIELD_NAME => 'Last Name',
        FieldConstants::FIELD_KEY => 'last_name',
        FieldConstants::FIELD_FORMATTER => function ($datum) use ($smiley_face): string {
            return strtoupper($datum['last_name']) . $smiley_face;
        },
    ],
    [
        FieldConstants::FIELD_NAME => 'Multi-line Field',
        FieldConstants::FIELD_KEY => 'multi_line',
        FieldConstants::FIELD_COLUMN_COLOR => TextColorEnum::WHITE,
    ],
    [
        FieldConstants::FIELD_KEY => 'interpolated_colors',
    ],
];

(new CliTableBuilder())
    ->setData($data)
    ->setFields($fields)
    ->setBorderColor(TextColorEnum::DARK_CYAN)
    ->setShowHeader(true)
    ->setEmptyCellPlaceholder('---')
    ->build();

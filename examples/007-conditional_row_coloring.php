<?php

global $mock_data;

use Spydr97\PhpCliTable\CliTableBuilder;
use Spydr97\PhpCliTable\Constants\DataConstants;
use Spydr97\PhpCliTable\Constants\FieldConstants;
use Spydr97\PhpCliTable\TextColorEnum;

require_once __DIR__ . '/../vendor/autoload.php';
require_once "000-data.php";

foreach ($mock_data as &$mock_datum) {
    $mock_datum[DataConstants::DATA_COLOR] = function ($datum): TextColorEnum {
        return match ($datum['gender']) {
            'Female' => TextColorEnum::MAGENTA,
            'Male' => TextColorEnum::BLUE,
            default => TextColorEnum::WHITE
        };
    };
}

$fields = [
    [
        FieldConstants::FIELD_KEY => 'id',
        FieldConstants::FIELD_NAME => 'ID',
    ],
    [
        FieldConstants::FIELD_KEY => 'first_name',
        FieldConstants::FIELD_NAME => 'First Name',
    ],
    [
        FieldConstants::FIELD_KEY => 'last_name',
        FieldConstants::FIELD_NAME => 'Last Name',
    ],
    [
        FieldConstants::FIELD_KEY => 'gender',
        FieldConstants::FIELD_NAME => 'Gender',
    ],
];

(new CliTableBuilder())
    ->setData($mock_data)
    ->setFields($fields)
    ->build();

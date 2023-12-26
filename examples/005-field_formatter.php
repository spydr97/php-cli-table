<?php

global $mock_data;

use Spydr97\PhpCliTable\CliTableBuilder;
use Spydr97\PhpCliTable\Constants\FieldConstants;

require_once __DIR__ . '/../vendor/autoload.php';
require_once "000-data.php";

$fields = [
    [
        FieldConstants::FIELD_KEY => 'id',
        FieldConstants::FIELD_NAME => 'ID',
    ],
    [
        FieldConstants::FIELD_KEY => 'full_name',
        FieldConstants::FIELD_FORMATTER => function ($datum): string {
            return $datum['first_name'] . ' ' . $datum['last_name'];
        },
    ],
    [
        FieldConstants::FIELD_KEY => 'gender',
    ],
    [
        FieldConstants::FIELD_KEY => 'ip_address',
        FieldConstants::FIELD_NAME => 'IP Address',
    ],
];

(new CliTableBuilder())
    ->setData($mock_data)
    ->setFields($fields)
    ->build();

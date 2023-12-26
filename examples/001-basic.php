<?php

global $mock_data;

use Spydr97\PhpCliTable\CliTableBuilder;

require_once __DIR__ . '/../vendor/autoload.php';
require_once "000-data.php";

(new CliTableBuilder())
    ->setData($mock_data)
    ->build();

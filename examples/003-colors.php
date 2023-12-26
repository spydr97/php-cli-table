<?php
global $mock_data;

use Spydr97\PhpCliTable\CliTableBuilder;
use Spydr97\PhpCliTable\TextColorEnum;

require_once __DIR__ . '/../vendor/autoload.php';
require_once "000-data.php";

(new CliTableBuilder())
    ->setData($mock_data)
    ->setBorderColor(TextColorEnum::BLUE)
    ->setHeaderColor(TextColorEnum::DARK_MAGENTA)
    ->setCellColor(TextColorEnum::CYAN)
    ->build();

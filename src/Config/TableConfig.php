<?php

namespace Spydr97\PhpCliTable\Config;

use Spydr97\PhpCliTable\TextColorEnum;

class TableConfig
{
    public static bool $SHOW_HEADER = true;
    public static string $EMPTY_CELL_PLACEHOLDER = "-";
    public static TextColorEnum $BORDER_COLOR = TextColorEnum::RESET;
    public static TextColorEnum $CELL_COLOR = TextColorEnum::RESET;
    public static TextColorEnum $HEADER_COLOR = TextColorEnum::RESET;
    public static TextColorEnum $RESET_COLOR = TextColorEnum::RESET;
}

<?php

namespace Spydr97\PhpCliTable;

use Spydr97\PhpCliTable\Constants\TextColorConstants;

enum TextColorEnum: string
{
    case BLACK = TextColorConstants::TEXT_COLOR_BLACK;
    case DARK_RED = TextColorConstants::TEXT_COLOR_DARK_RED;
    case DARK_GREEN = TextColorConstants::TEXT_COLOR_DARK_GREEN;
    case DARK_YELLOW = TextColorConstants::TEXT_COLOR_DARK_YELLOW;
    case DARK_BLUE = TextColorConstants::TEXT_COLOR_DARK_BLUE;
    case DARK_MAGENTA = TextColorConstants::TEXT_COLOR_DARK_MAGENTA;
    case DARK_CYAN = TextColorConstants::TEXT_COLOR_DARK_CYAN;
    case LIGHT_GREY = TextColorConstants::TEXT_COLOR_LIGHT_GREY;
    case DARK_GREY = TextColorConstants::TEXT_COLOR_DARK_GREY;
    case RED = TextColorConstants::TEXT_COLOR_RED;
    case GREEN = TextColorConstants::TEXT_COLOR_GREEN;
    case YELLOW = TextColorConstants::TEXT_COLOR_YELLOW;
    case BLUE = TextColorConstants::TEXT_COLOR_BLUE;
    case MAGENTA = TextColorConstants::TEXT_COLOR_MAGENTA;
    case CYAN = TextColorConstants::TEXT_COLOR_CYAN;
    case WHITE = TextColorConstants::TEXT_COLOR_WHITE;
    case RESET = TextColorConstants::TEXT_COLOR_RESET;
}

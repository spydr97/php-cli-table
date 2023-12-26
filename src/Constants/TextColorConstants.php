<?php

namespace Spydr97\PhpCliTable\Constants;

class TextColorConstants
{
    public const TEXT_COLOR_BLACK = TextColorConstants::ESCAPE_CHARACTER . '[1;30m';
    public const TEXT_COLOR_DARK_RED = TextColorConstants::ESCAPE_CHARACTER . '[1;31m';
    public const TEXT_COLOR_DARK_GREEN = TextColorConstants::ESCAPE_CHARACTER . '[1;32m';
    public const TEXT_COLOR_DARK_YELLOW = TextColorConstants::ESCAPE_CHARACTER . '[1;33m';
    public const TEXT_COLOR_DARK_BLUE = TextColorConstants::ESCAPE_CHARACTER . '[1;34m';
    public const TEXT_COLOR_DARK_MAGENTA = TextColorConstants::ESCAPE_CHARACTER . '[1;35m';
    public const TEXT_COLOR_DARK_CYAN = TextColorConstants::ESCAPE_CHARACTER . '[1;36m';
    public const TEXT_COLOR_LIGHT_GREY = TextColorConstants::ESCAPE_CHARACTER . '[1;37m';
    public const TEXT_COLOR_DARK_GREY = TextColorConstants::ESCAPE_CHARACTER . '[1;90m';
    public const TEXT_COLOR_RED = TextColorConstants::ESCAPE_CHARACTER . '[1;91m';
    public const TEXT_COLOR_GREEN = TextColorConstants::ESCAPE_CHARACTER . '[1;92m';
    public const TEXT_COLOR_YELLOW = TextColorConstants::ESCAPE_CHARACTER . '[1;93m';
    public const TEXT_COLOR_BLUE = TextColorConstants::ESCAPE_CHARACTER . '[1;94m';
    public const TEXT_COLOR_MAGENTA = TextColorConstants::ESCAPE_CHARACTER . '[1;95m';
    public const TEXT_COLOR_CYAN = TextColorConstants::ESCAPE_CHARACTER . '[1;96m';
    public const TEXT_COLOR_WHITE = TextColorConstants::ESCAPE_CHARACTER . '[1;97m';
    public const TEXT_COLOR_RESET = TextColorConstants::ESCAPE_CHARACTER . '[0m';
    private const ESCAPE_CHARACTER = "\033";
}

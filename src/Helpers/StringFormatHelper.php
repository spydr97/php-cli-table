<?php

namespace Spydr97\PhpCliTable\Helpers;

class StringFormatHelper
{
    /**
     * Add padding to the end of a string
     * @param string $string
     * @param int $length
     * @param string $pad_string
     * @return string
     */
    public static function padStringRight(string $string, int $length, string $pad_string = ' '): string
    {
        return str_pad($string, $length, $pad_string);
    }

    /**
     * Add padding to the beginning of a string
     * @param string $string
     * @param int $length
     * @param string $pad_string
     * @return string
     */
    public static function padStringLeft(string $string, int $length, string $pad_string = ' '): string
    {
        return str_pad($string, $length, $pad_string, STR_PAD_LEFT);
    }

    /**
     * Add equal padding to both the beginning and end of a string
     * @param string $string
     * @param int $length
     * @param string $pad_string
     * @return string
     */
    public static function padStringCenter(string $string, int $length, string $pad_string = ' '): string
    {
        return str_pad($string, $length, $pad_string, STR_PAD_BOTH);
    }

    /**
     * Adds a single space to the beginning of a string and normal right hand padding for the remaining length
     * @param string $string
     * @param int $length
     * @param string $pad_string
     * @return string
     */
    public static function padStringDefault(string $string, int $length, string $pad_string = ' '): string
    {
        $string = " " . $string;
        $ansi_stripped_string = self::removeAnsiCharsFromString($string);
        while (strlen($ansi_stripped_string) < $length) {
            $ansi_stripped_string .= $pad_string;
            $string .= $pad_string;
        }
        return $string;
    }

    /**
     * Removes ANSI escape code pattern with numbers from a string
     * @param string $string
     * @return string
     */
    public static function removeAnsiCharsFromString(string $string): string
    {
        return preg_replace('/\033\[(\d+;)*\d+m/', '', $string);
    }

    /**
     * Converts snake_case to TitleCase with the option to add spacing between words
     * @param string $string
     * @param bool $add_spaces
     * @return string
     */
    public static function snakeCaseToTitleCase(string $string, bool $add_spaces = true): string
    {
        if ($add_spaces) {
            $string = str_replace('_', ' ', $string);
        }
        return ucwords($string);
    }

    /**
     * Returns an array of strings split by any valid newline character
     * @param string $string
     * @return array
     */
    public static function splitStringOnNewLine(string $string): array
    {
        return preg_split("/\r\n|\n|\r/", $string);
    }
}

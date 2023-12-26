<?php

namespace Spydr97\PhpCliTable\Helpers;

use Spydr97\PhpCliTable\Config\TableConfig;
use Spydr97\PhpCliTable\Constants\CharacterConstants;
use Spydr97\PhpCliTable\Constants\DataConstants;
use Spydr97\PhpCliTable\Constants\FieldConstants;

class RowFormatHelper
{
    public static function getTableBorderTopRow(array $column_lengths): string
    {
        $table_border_top = TableConfig::$BORDER_COLOR->value;
        $table_border_top .= CharacterConstants::CHAR_BORDER_TOP_LEFT;
        $column_count = count($column_lengths);
        $current_count = 1;
        foreach ($column_lengths as $column_length) {
            foreach (range(1, $column_length) as $_ignored) { //phpcs:ignore SlevomatCodingStandard.Variables.UnusedVariable.UnusedVariable
                $table_border_top .= CharacterConstants::CHAR_BORDER_TOP;
            }
            if ($current_count != $column_count) {
                $table_border_top .= CharacterConstants::CHAR_BORDER_TOP_DIVIDER;
            }
            $current_count++;
        }
        $table_border_top .= CharacterConstants::CHAR_BORDER_TOP_RIGHT;
        $table_border_top .= PHP_EOL;
        $table_border_top .= TableConfig::$RESET_COLOR->value;
        return $table_border_top;
    }

    public static function getTableHeadingsRow(array $fields, array $column_lengths): string
    {
        $table_headings_row = TableConfig::$BORDER_COLOR->value;
        $table_headings_row .= CharacterConstants::CHAR_BORDER_LEFT;
        $table_headings_row .= TableConfig::$RESET_COLOR->value;
        $num_fields = count($fields);
        foreach ($fields as $index => $field) {
            $field_name = $field[FieldConstants::FIELD_NAME] ?? StringFormatHelper::snakeCaseToTitleCase($field[FieldConstants::FIELD_KEY]);
            $field_color = self::getTableHeadingColor($field);
            $table_headings_row .= $field_color;
            $table_headings_row .= StringFormatHelper::padStringCenter(
                $field_name,
                $column_lengths[$field[FieldConstants::FIELD_KEY]]
            );
            $table_headings_row .= TableConfig::$RESET_COLOR->value;
            if ($index != $num_fields - 1) {
                $table_headings_row .= TableConfig::$BORDER_COLOR->value;
                $table_headings_row .= CharacterConstants::CHAR_DIVIDER_VERTICAL;
                $table_headings_row .= TableConfig::$RESET_COLOR->value;
            }
        }
        $table_headings_row .= TableConfig::$BORDER_COLOR->value;
        $table_headings_row .= CharacterConstants::CHAR_BORDER_RIGHT;
        $table_headings_row .= TableConfig::$RESET_COLOR->value;
        $table_headings_row .= PHP_EOL;
        return $table_headings_row;
    }

    private static function getTableHeadingColor(array $field): string
    {
        if (isset($field[FieldConstants::FIELD_HEADER_COLOR])) {
            if (is_callable($field[FieldConstants::FIELD_HEADER_COLOR])) {
                if (!is_null($field[FieldConstants::FIELD_HEADER_COLOR]($field))) {
                    return $field[FieldConstants::FIELD_HEADER_COLOR]($field)->value;
                }
            } else {
                return $field[FieldConstants::FIELD_HEADER_COLOR]->value;
            }
        }

        return TableConfig::$HEADER_COLOR->value;
    }

    public static function getTableDividerRow(array $column_lengths): string
    {
        $table_divider_row = TableConfig::$BORDER_COLOR->value;
        $table_divider_row .= CharacterConstants::CHAR_BORDER_LEFT_DIVIDER;
        $column_count = count($column_lengths);
        $current_count = 1;
        foreach ($column_lengths as $column_length) {
            foreach (range(1, $column_length) as $_ignored) { //phpcs:ignore SlevomatCodingStandard.Variables.UnusedVariable.UnusedVariable
                $table_divider_row .= CharacterConstants::CHAR_DIVIDER_HORIZONTAL;
            }
            if ($current_count != $column_count) {
                $table_divider_row .= CharacterConstants::CHAR_DIVIDER_DIVIDER;
            }
            $current_count++;
        }
        $table_divider_row .= CharacterConstants::CHAR_BORDER_RIGHT_DIVIDER;
        $table_divider_row .= TableConfig::$RESET_COLOR->value;
        $table_divider_row .= PHP_EOL;
        return $table_divider_row;
    }

    public static function getTableDatumRow(array $datum, array $fields, array $column_lengths): string
    {
        $table_data_row = TableConfig::$BORDER_COLOR->value;
        $table_data_row .= CharacterConstants::CHAR_BORDER_LEFT;
        $table_data_row .= TableConfig::$RESET_COLOR->value;
        $num_fields = count($fields);
        foreach ($fields as $index => $field) {
            $table_data_row .= self::getTableDatumColor($datum, $field);
            $field_value = self::getTableDatumCellContent($datum, $field);
            $table_data_row .= StringFormatHelper::padStringDefault($field_value, $column_lengths[$field[FieldConstants::FIELD_KEY]]);
            $table_data_row .= TableConfig::$RESET_COLOR->value;
            if ($index != $num_fields - 1) {
                $table_data_row .= TableConfig::$BORDER_COLOR->value;
                $table_data_row .= CharacterConstants::CHAR_DIVIDER_VERTICAL;
                $table_data_row .= TableConfig::$RESET_COLOR->value;
            }
        }
        $table_data_row .= TableConfig::$BORDER_COLOR->value;
        $table_data_row .= CharacterConstants::CHAR_BORDER_RIGHT;
        $table_data_row .= TableConfig::$RESET_COLOR->value;
        $table_data_row .= PHP_EOL;
        return $table_data_row;
    }

    private static function getTableDatumCellContent(array $datum, array $field): string
    {
        return $datum[$field[FieldConstants::FIELD_KEY]];
    }

    private static function getTableDatumColor(array $datum, array $field): string
    {
        if (isset($datum[DataConstants::DATA_COLOR])) {
            if (is_callable($datum[DataConstants::DATA_COLOR])) {
                if (!is_null($datum[DataConstants::DATA_COLOR]($datum, $field))) {
                    return $datum[DataConstants::DATA_COLOR]($datum, $field)->value;
                }
            } else {
                return $datum[DataConstants::DATA_COLOR]->value;
            }
        }

        if (isset($field[FieldConstants::FIELD_COLUMN_COLOR])) {
            if (is_callable($field[FieldConstants::FIELD_COLUMN_COLOR])) {
                if (!is_null($field[FieldConstants::FIELD_COLUMN_COLOR]($datum, $field))) {
                    return $field[FieldConstants::FIELD_COLUMN_COLOR]($datum, $field)->value;
                }
            } else {
                return $field[FieldConstants::FIELD_COLUMN_COLOR]->value;
            }
        }

        return TableConfig::$CELL_COLOR->value;
    }

    public static function getTableBorderBottomRow(array $column_lengths): string
    {
        $table_border_bottom = TableConfig::$BORDER_COLOR->value;
        $table_border_bottom .= CharacterConstants::CHAR_BORDER_BOTTOM_LEFT;
        $column_count = count($column_lengths);
        $current_count = 1;
        foreach ($column_lengths as $column_length) {
            foreach (range(1, $column_length) as $_) { //phpcs:ignore SlevomatCodingStandard.Variables.UnusedVariable.UnusedVariable
                $table_border_bottom .= CharacterConstants::CHAR_BORDER_BOTTOM;
            }
            if ($current_count != $column_count) {
                $table_border_bottom .= CharacterConstants::CHAR_BORDER_BOTTOM_DIVIDER;
            }
            $current_count++;
        }
        $table_border_bottom .= CharacterConstants::CHAR_BORDER_BOTTOM_RIGHT;
        $table_border_bottom .= PHP_EOL;
        $table_border_bottom .= TableConfig::$RESET_COLOR->value;
        return $table_border_bottom;
    }
}

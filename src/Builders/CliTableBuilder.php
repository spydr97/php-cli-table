<?php

namespace Spydr97\PhpCliTable\Builders;

use Spydr97\PhpCliTable\Config\TableConfig;
use Spydr97\PhpCliTable\Constants\DataConstants;
use Spydr97\PhpCliTable\Constants\FieldConstants;
use Spydr97\PhpCliTable\Exceptions\InvalidEnvironmentException;
use Spydr97\PhpCliTable\Exceptions\UndefinedDataException;
use Spydr97\PhpCliTable\Helpers\DataValidationHelper;
use Spydr97\PhpCliTable\Helpers\RowFormatHelper;
use Spydr97\PhpCliTable\Helpers\StringFormatHelper;
use Spydr97\PhpCliTable\TextColorEnum;

class CliTableBuilder
{
    private array $data;
    private array $formatted_data;
    private array $fields;
    private array $column_widths;

    public function __construct()
    {
        if (php_sapi_name() != 'cli') {
            throw new InvalidEnvironmentException("PHP CLI Table can only be instantiated via CLI");
        }
    }

    public function setData(array $data): CliTableBuilder
    {
        $this->data = $data;
        return $this;
    }

    public function setFields(array $fields): CliTableBuilder
    {
        $this->fields = $fields;
        return $this;
    }

    public function setBorderColor(TextColorEnum $color): CliTableBuilder
    {
        TableConfig::$BORDER_COLOR = $color;
        return $this;
    }

    public function setHeaderColor(TextColorEnum $color): CliTableBuilder
    {
        TableConfig::$HEADER_COLOR = $color;
        return $this;
    }

    public function setCellColor(TextColorEnum $color): CliTableBuilder
    {
        TableConfig::$CELL_COLOR = $color;
        return $this;
    }

    public function setEmptyCellPlaceholder(string $empty_cell_placeholder): CliTableBuilder
    {
        TableConfig::$EMPTY_CELL_PLACEHOLDER = $empty_cell_placeholder;
        return $this;
    }

    public function setShowHeader(bool $show_header): CliTableBuilder
    {
        TableConfig::$SHOW_HEADER = $show_header;
        return $this;
    }

    public function build(): void
    {
        print $this->generate();
    }

    private function generate(): string
    {
        if (!isset($this->data)) {
            throw new UndefinedDataException("Data has not been initialized. Did you forget to call setData()?");
        }

        if (!isset($this->fields)) {
            $this->setFieldsFromData();
        }

        DataValidationHelper::assertValid($this->data, $this->fields);

        $this->setFormattedData();

        $this->setTableColumnWidths();

        $table = RowFormatHelper::getTableBorderTopRow($this->column_widths);
        if (TableConfig::$SHOW_HEADER) {
            $table .= RowFormatHelper::getTableHeadingsRow($this->fields, $this->column_widths);
            $table .= RowFormatHelper::getTableDividerRow($this->column_widths);
        }

        foreach ($this->formatted_data as $datum) {
            $table .= RowFormatHelper::getTableDatumRow($datum, $this->fields, $this->column_widths);
        }

        $table .= RowFormatHelper::getTableBorderBottomRow($this->column_widths);

        return $table;
    }

    private function setFormattedData(): void
    {
        $formatted_data = [];

        foreach ($this->data as $datum) {
            $formatted_data_item = [];
            $split_data_fields = [];

            foreach ($this->fields as $field) {
                $field_key = $field[FieldConstants::FIELD_KEY];
                if (isset($field[FieldConstants::FIELD_FORMATTER])) {
                    $field_value = $field[FieldConstants::FIELD_FORMATTER]($datum, $field);
                } else {
                    if (isset($datum[$field_key])) {
                        $field_value = $datum[$field_key];
                    } else {
                        $field_value = TableConfig::$EMPTY_CELL_PLACEHOLDER;
                    }
                }
                $split_data_field_items = StringFormatHelper::splitStringOnNewLine($field_value);
                if (count($split_data_field_items) > 1) {
                    $split_data_fields[$field_key] = $split_data_field_items;
                }
                $formatted_data_item[$field_key] = $field_value;
                if (isset($datum[DataConstants::DATA_COLOR])) {
                    $formatted_data_item[DataConstants::DATA_COLOR] = $datum[DataConstants::DATA_COLOR];
                }
            }

            if (count($split_data_fields) > 0) {
                $largest_size = 0;

                foreach ($split_data_fields as $split_data_field) {
                    $largest_size = max($largest_size, count($split_data_field));
                }

                foreach (range(0, $largest_size - 1) as $index) {
                    $formatted_split_data_item = [];

                    foreach ($formatted_data_item as $formatted_data_item_key => $formatted_data_item_value) {
                        if (isset($split_data_fields[$formatted_data_item_key][$index])) {
                            $formatted_split_data_item[$formatted_data_item_key] = $split_data_fields[$formatted_data_item_key][$index];
                        } else {
                            if ($index == 0) {
                                $formatted_split_data_item[$formatted_data_item_key] = $formatted_data_item_value;
                            } else {
                                if (!str_starts_with($formatted_data_item_key, '_')) {
                                    $formatted_split_data_item[$formatted_data_item_key] = "";
                                } else {
                                    $formatted_split_data_item[$formatted_data_item_key] = $formatted_data_item_value;
                                }
                            }
                        }
                    }
                    $formatted_data[] = $formatted_split_data_item;
                }
            } else {
                $formatted_data[] = $formatted_data_item;
            }
        }

        $this->formatted_data = $formatted_data;
    }

    private function setFieldsFromData(): void
    {
        $fields = [];
        if (isset($this->data[0])) {
            foreach (array_keys($this->data[0]) as $array_key) {
                if (!str_starts_with($array_key, '_')) {
                    $fields[] = [
                        FieldConstants::FIELD_KEY => $array_key,
                        FieldConstants::FIELD_NAME => StringFormatHelper::snakeCaseToTitleCase($array_key),
                    ];
                }
            }
        }
        $this->setFields($fields);
    }

    private function setTableColumnWidths(): void
    {
        $column_widths = [];
        foreach ($this->fields as $field) {
            $field_key = $field[FieldConstants::FIELD_KEY];

            foreach ($this->data as $datum) {
                if (!isset($column_widths[$field_key])) {
                    $column_widths[$field_key] = 0;
                }

                if (isset($field[FieldConstants::FIELD_FORMATTER])) {
                    $current_field_value = $field[FieldConstants::FIELD_FORMATTER]($datum, $field);
                } else {
                    if (isset($datum[$field_key])) {
                        $current_field_value = $datum[$field_key];
                    } else {
                        $current_field_value = TableConfig::$EMPTY_CELL_PLACEHOLDER;
                    }
                }
                $current_field_value = StringFormatHelper::removeAnsiCharsFromString($current_field_value);
                $column_widths[$field_key] = max($column_widths[$field_key], strlen($current_field_value) + 2);
            }
            $field_name = $field[FieldConstants::FIELD_NAME] ?? StringFormatHelper::snakeCaseToTitleCase($field[FieldConstants::FIELD_KEY]);
            if (isset($column_widths[$field[FieldConstants::FIELD_KEY]])) {
                $column_widths[$field[FieldConstants::FIELD_KEY]] = max(strlen($field_name) + 2, $column_widths[$field[FieldConstants::FIELD_KEY]]);
            } else {
                $column_widths[$field[FieldConstants::FIELD_KEY]] = strlen($field_name) + 2;
            }
        }
        $this->column_widths = $column_widths;
    }
}

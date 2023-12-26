<?php

namespace Spydr97\PhpCliTable\Helpers;

use Spydr97\PhpCliTable\Constants\DataConstants;
use Spydr97\PhpCliTable\Constants\FieldConstants;
use Spydr97\PhpCliTable\Exceptions\InvalidDataException;
use Spydr97\PhpCliTable\Exceptions\InvalidFieldException;
use Spydr97\PhpCliTable\TextColorEnum;

class DataValidationHelper
{

    public static function assertValid(array $data, array $fields)
    {
        if (!empty($fields)) {
            self::assertValidFields($fields);
        }

        self::assertValidData($data, $fields);
    }

    private static function assertValidData(array $data, array $fields): void
    {
        if (empty($data)) {
            throw new InvalidDataException("data cannot be an empty array");
        }

        foreach ($data as $index => $datum) {
            if (isset($datum[DataConstants::DATA_COLOR])) {
                $type = gettype($datum[DataConstants::DATA_COLOR]);
                if (!is_a($datum[DataConstants::DATA_COLOR], TextColorEnum::class) && !is_callable($datum[DataConstants::DATA_COLOR])) {
                    $field = DataConstants::DATA_COLOR;
                    throw new InvalidDataException("Data property '$field' at index $index expected to be of type 'callable' or 'ColorEnum', received '$type'");
                }

                if (is_callable($datum[DataConstants::DATA_COLOR])) {
                    foreach ($fields as $field) {
                        $color_enum = $datum[DataConstants::DATA_COLOR]($datum, $field);
                        if (!$color_enum instanceof TextColorEnum && !is_null($color_enum)) {
                            $type = gettype($color_enum);
                            throw new InvalidFieldException("Field property '_color' callable expected to return type 'ColorEnum' or 'null', received '$type'");
                        }
                    }
                }
            }
        }
    }

    private static function assertValidFields(array $fields): void
    {
        foreach ($fields as $field) {
            self::assertValidHeaderStringField($field, FieldConstants::FIELD_KEY, false);
            self::assertValidHeaderStringField($field, FieldConstants::FIELD_NAME, true);

            foreach ([FieldConstants::FIELD_HEADER_COLOR, FieldConstants::FIELD_COLUMN_COLOR] as $color_field_key) {
                self::assertValidHeaderColorField($field, $color_field_key);
            }
        }
    }

    private static function assertValidHeaderStringField(array $field, string $string_field_key, bool $optional)
    {
        if (!$optional && !isset($field[$string_field_key])) {
            throw new InvalidFieldException("Field expected to have property '$string_field_key' of type 'string'. Field data: " . json_encode($field));
        }
        if (isset($field[$string_field_key]) && !is_string($field[$string_field_key])) {
            $type = gettype($field[$string_field_key]);
            throw new InvalidFieldException("Field property '$string_field_key' expected to be of type 'string', received '$type'");
        }
    }

    private static function assertValidHeaderColorField(array $field, string $color_field_key): void
    {
        if (isset($field[$color_field_key])) {
            $type = gettype($field[$color_field_key]);
            if (!is_a($field[$color_field_key], TextColorEnum::class) && !is_callable($field[$color_field_key])) {
                throw new InvalidFieldException("Field property $color_field_key expected to be of type 'callable' or 'ColorEnum', received '$type'");
            }

//            if (is_callable($field[$color_field_key])) {
//                $color_enum = $field[$color_field_key]($field);
//                if (!is_a($color_enum, TextColorEnum::class)) {
//                    $type = gettype($color_enum);
//                    throw new InvalidFieldException("Field property $color_field_key callable expected to return type 'ColorEnum', received '$type'");
//                }
//            }
        }
    }
}

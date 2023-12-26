<?php

namespace Spydr97\PhpCliTable\Builders;

use Closure;
use Spydr97\PhpCliTable\Constants\FieldConstants;
use Spydr97\PhpCliTable\Exceptions\InvalidFieldException;
use Spydr97\PhpCliTable\TextColorEnum;

class FieldBuilder
{
    private string $key;
    private string $name;

    private TextColorEnum|Closure $column_color;
    private TextColorEnum|Closure $header_color;
    private Closure $formatter;

    /**
     * @param string $key
     * @return FieldBuilder
     */
    public function setKey(string $key): FieldBuilder
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param string $name
     * @return FieldBuilder
     */
    public function setName(string $name): FieldBuilder
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Closure|TextColorEnum $column_color
     * @return FieldBuilder
     */
    public function setColumnColor(TextColorEnum|Closure $column_color): FieldBuilder
    {
        $this->column_color = $column_color;
        return $this;
    }

    /**
     * @param Closure|TextColorEnum $header_color
     * @return FieldBuilder
     */
    public function setHeaderColor(TextColorEnum|Closure $header_color): FieldBuilder
    {
        $this->header_color = $header_color;
        return $this;
    }

    /**
     * @param Closure $formatter
     * @return FieldBuilder
     */
    public function setFormatter(Closure $formatter): FieldBuilder
    {
        $this->formatter = $formatter;
        return $this;
    }

    public function build(): array
    {
        if (!isset($key)) {
            throw new InvalidFieldException("Field build method called without a valid 'key'. Did you forget to call setKey()?");
        }
        return [
            FieldConstants::FIELD_KEY => $this->key,
            FieldConstants::FIELD_NAME => $this->name ?? null,
            FieldConstants::FIELD_COLUMN_COLOR => $this->column_color ?? null,
            FieldConstants::FIELD_HEADER_COLOR => $this->header_color ?? null,
            FieldConstants::FIELD_FORMATTER => $this->formatter ?? null,
        ];
    }
}

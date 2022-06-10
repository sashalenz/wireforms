<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\DateTime;
use Sashalenz\Wireforms\Contracts\FieldContract;

class DateTimeField extends FormField
{
    private bool $allowClear = false;
    private bool $time = false;
    private ?string $format = 'Y-m-d';
    private ?string $timeFormat = 'Y-m-d H:i';
    private ?string $mode = 'single';

    public function allowClear(): self
    {
        $this->allowClear = true;

        return $this;
    }

    public function time(): self
    {
        $this->time = true;

        return $this;
    }

    public function format(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function timeFormat(string $timeFormat): self
    {
        $this->timeFormat = $timeFormat;

        return $this;
    }

    public function mode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    protected function render(): FieldContract
    {
        return DateTime::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            label: $this->label,
            allowClear: $this->allowClear,
            time: $this->time,
            format: $this->format,
            timeFormat: $this->timeFormat,
            mode: $this->mode,
            help: $this->help,
            key: $this->key,
            placeholder: $this->placeholder,
            required: $this->required,
            disabled: $this->disabled
        );
    }
}

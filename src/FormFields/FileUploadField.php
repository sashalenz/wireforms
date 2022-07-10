<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\FileUpload;
use Sashalenz\Wireforms\Contracts\FieldContract;

class FileUploadField extends FormField
{
    public function __construct(
        protected string $name,
        protected ?string $label = null
    ) {
        parent::__construct($name, $label);
        $this->exceptFromModel();
    }

    protected function render(): FieldContract
    {
        return FileUpload::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            label: $this->label,
            help: $this->help,
            key: $this->key,
            placeholder: $this->placeholder,
            required: $this->required,
            disabled: $this->disabled
        );
    }
}

<?php

namespace Sashalenz\Wireforms\FormFields;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class SingleImageField extends Field
{
    public function render(): View
    {
        return view('wireforms::field.single-image-field');
    }

    public function renderIt(?Model $model = null): ?View
    {
        $condition = is_callable($this->displayCondition) ? call_user_func($this->displayCondition, $model) : true;

        if ((bool) $condition === false) {
            return null;
        }

        if (! is_null($model)) {
            $this->setValue($model->getFirstMediaUrl($this->getName()));
        }

        return $this->render()->with($this->data());
    }
}

<?php

namespace Sashalenz\Wireforms\Contracts;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

interface FormFieldContract
{
    public function renderIt(?Model $model = null): ?View;
}

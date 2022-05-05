<?php

namespace Sashalenz\Wireforms\Contracts;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

interface FormFieldContract
{
    public function getName(): string;

    public function getNameOrWireModel(): string;

    public function getDefault(): string;

    public function getRules(): array;

    public function wireModel(string $wireModel): self;

    public function renderIt(?Model $model = null): ?View;
}

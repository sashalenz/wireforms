<?php

namespace Sashalenz\Wireforms\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface FormFieldContract
{
    public function getName(): string;

    public function getNameOrWireModel(): string;

    public function getDefault():? string;

    public function getRules(): array;

    public function wireModel(string $wireModel): self;

    public function renderField(?Model $model = null): Collection;

    public function renderIt(?Model $model = null):? array;
}

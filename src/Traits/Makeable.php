<?php

namespace Sashalenz\Wireforms\Traits;

trait Makeable
{
    public static function make(...$attributes): static
    {
        return new static(...$attributes);
    }
}

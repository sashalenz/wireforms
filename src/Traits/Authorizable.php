<?php

namespace Sashalenz\Wireforms\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait Authorizable
{
    use AuthorizesRequests;
    public bool $canRender = true;

    public function canSee(string $ability, string $model): self
    {
        $this->canRender = $this->authorizeModel($ability, $model);

        return $this;
    }

    private function authorizeModel(string $ability, Model|string $model): bool
    {
        try {
            $this->authorize($ability, $model);

            return true;
        } catch (AuthorizationException) {
            return false;
        }
    }
}

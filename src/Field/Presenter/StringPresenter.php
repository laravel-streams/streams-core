<?php

namespace Streams\Core\Field\Presenter;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Streams\Core\Field\FieldPresenter;

class StringPresenter extends FieldPresenter
{

    public function lines()
    {
        return explode("\n", $this->value);
    }

    public function render(array $payload = [])
    {
        return Str::markdown(View::parse($this->value, $payload));
    }

    public function __call($method, $arguments)
    {
        return Str::{$method}($this->value, ...$arguments);
    }

    /**
     * Normalize the URL by default.
     *
     * @return bool|string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}

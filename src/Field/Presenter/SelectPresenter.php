<?php

namespace Streams\Core\Field\Presenter;

use Illuminate\Support\Arr;
use Streams\Core\Field\FieldPresenter;

class SelectPresenter extends FieldPresenter
{

    public function value()
    {
        return Arr::get($this->field->options(), $this->value);
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

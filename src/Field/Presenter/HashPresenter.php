<?php

namespace Streams\Core\Field\Presenter;

use Illuminate\Support\Facades\Hash;
use Streams\Core\Field\FieldPresenter;

class HashPresenter extends FieldPresenter
{
    public function check($value): bool
    {
        return Hash::check($value, $this->value);
    }
}

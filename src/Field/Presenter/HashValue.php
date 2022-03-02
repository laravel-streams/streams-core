<?php

namespace Streams\Core\Field\Presenter;

use Illuminate\Support\Facades\Hash;

class HashPresenter extends FieldPresenter
{

    /**
     * Compare a value to
     * the hashed value.
     *
     * @param $value
     */
    public function check($value)
    {
        return Hash::check($value, $this->value);
    }
}

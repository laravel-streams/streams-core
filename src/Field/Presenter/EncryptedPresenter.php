<?php

namespace Streams\Core\Field\Presenter;

use Illuminate\Support\Facades\Crypt;
use Streams\Core\Field\FieldPresenter;

class EncryptedPresenter extends FieldPresenter
{
    public function decrypt(): string
    {
        return Crypt::decrypt($this->value);
    }
}

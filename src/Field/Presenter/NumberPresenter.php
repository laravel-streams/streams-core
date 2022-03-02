<?php

namespace Streams\Core\Field\Presenter;

use Streams\Core\Field\FieldPresenter;

class NumberPresenter extends FieldPresenter
{
    public function isEven(): bool
    {
        return $this->value % 2 == 0;
    }
    
    public function isOdd(): bool
    {
        return $this->value % 2 != 0;
    }
}

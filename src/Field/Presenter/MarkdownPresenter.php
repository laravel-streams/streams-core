<?php

namespace Streams\Core\Field\Presenter;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Streams\Core\Field\FieldPresenter;

class MarkdownPresenter extends FieldPresenter
{
    public function parse()
    {
        return Str::markdown($this->value);
    }
    
    public function render(array $payload = [])
    {
        return Str::markdown(View::parse($this->value, $payload));
    }
}

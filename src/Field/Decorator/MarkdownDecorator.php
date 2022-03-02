<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Streams\Core\Field\FieldDecorator;

class MarkdownDecorator extends FieldDecorator
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

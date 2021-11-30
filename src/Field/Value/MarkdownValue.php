<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class MarkdownValue extends Value
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

<?php

namespace Streams\Core\Field\Factory;

use Illuminate\Support\Str;

class UuidGenerator extends Generator
{
    public function create()
    {
        return (string) Str::uuid();
    }
}

<?php

namespace Streams\Core\Field\Factory;

use Illuminate\Support\Facades\Hash;

class HashGenerator extends StrGenerator
{
    public function create()
    {
        return Hash::make($this->faker()->text(15, 50));
    }
}

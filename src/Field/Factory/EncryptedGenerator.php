<?php

namespace Streams\Core\Field\Factory;

use Illuminate\Support\Facades\Crypt;

class EncryptedGenerator extends Generator
{
    public function create()
    {
        return Crypt::encrypt($this->faker()->text(15, 50));
    }
}

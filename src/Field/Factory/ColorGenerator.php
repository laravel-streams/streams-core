<?php

namespace Streams\Core\Field\Factory;

class ColorGenerator extends Generator
{
    public function create()
    {
        return '#' . str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
    }
}

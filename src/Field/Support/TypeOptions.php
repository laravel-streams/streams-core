<?php

namespace Streams\Core\Field\Types\Support;


class TypeOptions
{
    public function handle($type)
    {
        return array_keys(config('streams.core.field_types'));
    }
}

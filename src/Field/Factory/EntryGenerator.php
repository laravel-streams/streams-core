<?php

namespace Streams\Core\Field\Factory;

class EntryGenerator extends Generator
{
    public function create()
    {
        return $this->field->stream()->factory()->create();
    }
}

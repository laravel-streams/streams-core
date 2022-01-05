<?php

namespace Streams\Core\Field;

use Illuminate\Support\Collection;

class FieldCollection extends Collection
{

    public function __get($key): ?Field
    {
        return $this->get($key);
    }

    public function required($required = true): self
    {
        return $this->filter(fn ($field) => $field->hasRule('required') === $required);
    }
}

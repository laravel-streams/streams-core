<?php

namespace Streams\Core\Field\Factory;

class CollectionGenerator extends Generator
{
    public function create()
    {
        for ($i = 0; $i < 10; $i++) {
            $values[] = $this->faker()->text(10);
        }

        $abstract = $this->type->config('abstract', \Illuminate\Support\Collection::class);

        return new $abstract($values);
    }
}

<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ArrValue;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Field\Schema\StructureSchema;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Support\Facades\Streams;

class Structure extends FieldType
{
    public function modify($value)
    {
        if ($value instanceof EntryInterface) {
            $value = [
                '@stream' => $value->stream()->id,
            ] + $value->getAttributes();
        }

        return $value;
    }

    public function restore($value)
    {
        $meta = preg_grep('/^\@/', array_keys($value));

        $meta = array_intersect_key($value, array_flip($meta));

        array_map(function ($key) use (&$value) {
            unset($value[$key]);
        }, array_keys($meta));
        
        if (isset($meta['@stream'])) {
            return Streams::repository($meta['@stream'])->newInstance($value);
        }

        return (object) $value;
    }

    public function expand($value)
    {
        dump($value);
    }

    public function getSchemaName()
    {
        return StructureSchema::class;
    }

    public function generate()
    {
        for ($i = 0; $i < 10; $i++) {
            $values[$this->generator()->word()] = $this->generator()->randomElement([
                $this->generator()->word(),
                $this->generator()->randomNumber(),
            ]);
        }

        return $values;
    }
}

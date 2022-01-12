<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Illuminate\Support\Collection;
use Streams\Core\Field\Value\ArrValue;
use Streams\Core\Field\Schema\ArrSchema;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Entry\Contract\EntryInterface;

class ArrayFieldType extends Field
{
    protected $__attributes = [
        'rules' => [
            'array',
        ],
    ];

    public function modify($value)
    {
        if ($value instanceof Collection) {
            $value = $value->all();
        }
        
        $values = array_values($value);

        foreach ($values as &$value) {

            if (is_object($value) && $value instanceof EntryInterface) {
                $value = [
                    '@stream' => $value->stream()->id,
                ] + $value->getAttributes();
            }

            if (is_object($value) && in_array(Prototype::class, class_uses($value))) {
                $value = [
                    '@prototype' => get_class($value),
                ] + $value->getPrototypeAttributes();
            }

            if (is_object($value) && $value instanceof Arrayable) {
                $value = [
                    '@abstract' => get_class($value),
                ] + $value->toArray();
            }

            if (is_object($value)) {
                $value = [
                    '@abstract' => get_class($value),
                ] + Hydrator::dehydrate($value);
            }
        }

        return $values;
    }

    public function restore($value)
    {
        if (is_object($value)) {
            return $value;
        }

        $values = array_values($value);

        foreach ($values as &$value) {

            if (!is_array($value)) {
                continue;
            }

            [$meta, $value] = $this->separateMeta($value);

            if (isset($meta['@stream'])) {
                $value = $this->restoreStreamEntry($meta, $value);
            }

            if (isset($meta['@prototype'])) {
                $value = $this->restorePrototype($meta, $value);
            }

            if (isset($meta['@abstract'])) {
                $value = $this->restoreInstance($meta, $value);
            }
        }

        if ($wrapper = $this->config('wrapper')) {
            $values = $this->wrapArray($values, $wrapper);
        }

        return $values;
    }

    public function getValueName()
    {
        return ArrValue::class;
    }

    public function getSchemaName()
    {
        return ArrSchema::class;
    }

    public function generate()
    {
        for ($i = 0; $i < 10; $i++) {
            $values[] = $this->generator()->randomElement([
                $this->generator()->word(),
                $this->generator()->randomNumber(),
            ]);
        }

        return $values;
    }

    protected function wrapArray($array, $wrapper)
    {
        if ($wrapper == 'array') {
            return $array;
        }

        if ($wrapper == 'collection') {
            return new Collection($array);
        }

        return new $wrapper($array);
    }

    protected function separateMeta(array $value)
    {
        $meta = preg_grep('/^\@/', array_keys($value));

        $meta = array_intersect_key($value, array_flip($meta));

        array_map(function ($key) use (&$value) {
            unset($value[$key]);
        }, array_keys($meta));

        return [$meta, $value];
    }

    protected function restoreStreamEntry(array $meta, array $value)
    {
        return Streams::repository($meta['@stream'])->newInstance($value);
    }

    protected function restorePrototype(array $meta, array $value)
    {
        return new $meta['@prototype']($value);
    }

    protected function restoreInstance(array $meta, array $value)
    {
        return new $meta['@instance']($value);
    }
}

<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Field\Schema\StructureSchema;
use Streams\Core\Entry\Contract\EntryInterface;

class ObjectFieldType extends Field
{
    public function modify($value)
    {
        if (is_object($value) && $value instanceof EntryInterface) {
            $value = [
                '@stream' => $value->stream()->id,
            ] + $value->getAttributes();
        }

        if (
            is_object($value) && ($value instanceof Arrayable
                || in_array(Prototype::class, class_uses($value)))
        ) {
            $value = array_merge([
                '@abstract' => get_class($value),
            ], $value->toArray());
        }

        if (is_object($value)) {
            $value = Hydrator::dehydrate($value);
        }

        return $value;
    }

    public function restore($value)
    {
        [$meta, $value] = $this->separateMeta($value);

        if (isset($meta['@stream'])) {
            return $this->restoreStreamEntry($meta, $value);
        }

        if (isset($meta['@abstract'])) {
            return $this->restoreInstance($meta, $value);
        }

        return (object) $value;
    }

    public function cast($value)
    {
        if (is_object($value)) {
            return $value;
        }

        if (is_string($value) && ($json = json_decode($value)) !== null) {
            return $json;
        }

        if (is_string($value) && Str::isSerialized($value)) {
            return unserialize($value);
        }

        return (object) $value;
    }

    // public function getSchemaName()
    // {
    //     return StructureSchema::class;
    // }

    // public function generate()
    // {
    //     for ($i = 0; $i < 10; $i++) {
    //         $values[$this->generator()->word()] = $this->generator()->randomElement([
    //             $this->generator()->word(),
    //             $this->generator()->randomNumber(),
    //         ]);
    //     }

    //     return $values;
    // }

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

    protected function restoreInstance(array $meta, array $value)
    {
        return new $meta['@abstract']($value);
    }
}

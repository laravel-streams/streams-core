<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Schema\ObjectSchema;
use Streams\Core\Entry\Contract\EntryInterface;

class PolymorphicFieldType extends Field
{
    public function modify($value)
    {
        if (is_object($value) && $value instanceof EntryInterface) {

            $keyName = $value->stream()->config('key_name', 'id');

            $value = [
                '@stream' => $value->stream()->id,
                $keyName => $value->getAttribute($keyName),
            ];
        }

        return $value;
    }

    public function restore($value)
    {
        [$meta, $value] = $this->separateMeta((array) $value);

        if (isset($meta['@stream'])) {
            return $this->restoreStreamEntry($meta, $value);
        }

        return $value;
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
        $stream = Streams::make($meta['@stream']);

        return $stream->repository()->find($value[$stream->config('key_name', 'id')]);
    }

    public function getSchemaName()
    {
        return ObjectSchema::class;
    }
}

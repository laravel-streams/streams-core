<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Collection;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Field\FieldType;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

class Entries extends FieldType
{
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'rules' => [],
        ], $attributes));
    }

    public function modify($value)
    {
        if ($value instanceof Collection) {
            $value = $value->map(function (EntryInterface $entry) {
                return $entry->getAttributes();
            })->all();
        }

        return $value;
    }

    public function cast($value)
    {
        if ($value instanceof Collection) {
            return $value;
        }

        $stream = $this->stream();

        return $stream->repository()->newCollection(array_map(function ($value) use ($stream) {
            return $stream->repository()->newInstance($value);
        }, (array)$value));
    }

    public function expand($value)
    {
        return $this->cast($value);
    }

    public function generate()
    {
        return $this->stream()->factory()->collect(2);
    }

    public function stream(): Stream
    {
        return Streams::make($this->field->config('stream'));
    }
}

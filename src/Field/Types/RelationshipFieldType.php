<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Support\Facades\Streams;

class RelationshipFieldType extends Field
{
    public function modify($value)
    {
        if (is_numeric($value)) {
            return (int) $value;
        }

        if (is_string($value)) {
            return $value;
        }

        $keyName = $this->related()->config('key_name', 'id');

        return $value->{$keyName};
    }

    public function decorate($value)
    {
        if (is_object($value)) {
            return $value;
        }

        return $this->related()->repository()->find($value);
    }

    public function related()
    {
        $stream = $this->config('related');

        return $this->once(
            $this->handle . '.related.' . $stream,
            function () use ($stream) {
                return Streams::make($stream);
            }
        );
    }

    public function default($value)
    {
        return $this->toCarbon($value);
    }

    public function generator()
    {
        return function () {

            $stream = $this->related();

            $entries = $stream->entries()->limit(100)->get();

            $keyName = $stream->config('key_name', 'id');

            if ($entries->isEmpty()) {
                return null;
            }

            if (!$entry = $entries->random()) {
                return null;
            }

            return $entry->{$keyName};
        };
    }
}

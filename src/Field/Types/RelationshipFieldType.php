<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Streams\Core\Support\Facades\Streams;

class RelationshipFieldType extends Field
{
    /**
     * The public relation name for this field (handle with a trailing
     * `_id` stripped, or an explicit `config('relation')` override).
     *
     * Used for `with[]=` eager loading and the response/attribute key
     * eager-loaded data is attached under. Read/presentation-only: writes
     * still use the raw field handle, and assigning `$entry->{relationName}`
     * directly does not sync back to the FK attribute.
     */
    public function relationName(): string
    {
        if ($relation = $this->config('relation')) {
            return $relation;
        }

        return Str::endsWith($this->handle, '_id')
            ? Str::beforeLast($this->handle, '_id')
            : $this->handle;
    }

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
            $this->handle.'.related.'.$stream,
            function () use ($stream) {
                return Streams::make($stream);
            }
        );
    }

    public function default($value)
    {
        if ($value == 'auth_id') {
            return Auth::check() ? Auth::id() : null;
        }

        return $value;
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

            if (! $entry = $entries->random()) {
                return null;
            }

            return $entry->{$keyName};
        };
    }
}

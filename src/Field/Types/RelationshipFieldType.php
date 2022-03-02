<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Support\Facades\Streams;

class RelationshipFieldType extends Field
{
    public function restore($value)
    {
        return $this->decorate($value);
    }

    public function expand($value)
    {
        if (is_object($value)) {
            return $value;
        }
        
        return Streams::repository($this->config('related'))->find($value);
    }

    public function generate()
    {
        $stream = Streams::make($this->config('related'));
        
        $entries = $stream->entries()->limit(100)->get();

        $keyName = $stream->config('key_name', 'id');

        if ($entries->isEmpty()) {
            return null;
        }
        
        if (!$entry = $entries->random()) {
            return null;
        }
        
        return $entry->{$keyName};
    }
}

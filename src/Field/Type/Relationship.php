<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;

class Relationship extends FieldType
{
    public function expand($value)
    {
        return Streams::entries($this->field->config('related'))->find($value);
    }

    public function generate()
    {
        $stream = Streams::make($this->field->config('related'));
        
        $entries = $stream->entries()->limit(100)->get();

        $keyName = $stream->config('key_name', 'id');

        if (!$entry = $entries->random()) {
            return null;
        }
        
        return $entry->{$keyName};
    }
}

<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryTableParser
{
    public function parse(StreamModel $stream)
    {
        return "{$stream->prefix}{$stream->slug}";
    }
}
 
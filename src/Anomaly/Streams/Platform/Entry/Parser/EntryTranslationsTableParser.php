<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryTranslationsTableParser
{

    public function parse(StreamModel $stream)
    {
        return "{$stream->prefix}{$stream->slug}_translations";
    }
}
 
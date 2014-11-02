<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryTranslationsClassParser
{

    public function parse(StreamModel $stream)
    {
        return studly_case("{$stream->namespace}_{$stream->slug}") . 'EntryTranslationsModel';
    }
}
 
<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryTranslationForeignKeyParser
{

    public function parse(StreamModel $stream)
    {
        return 'protected $translationForeignKey = \'' . str_singular($stream->slug) . '_id' . '\';';
    }
}

<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryTranslationModelParser
{

    public function parse(StreamModel $stream)
    {
        $namespace = studly_case($stream->namespace);
        $class     = studly_case("{$stream->namespace}_{$stream->slug}") . 'EntryTranslationsModel';

        return 'protected $translationModel = \'Anomaly\Streams\Platform\Model\\' . $namespace . '\\' . $class . '\';';
    }
}

<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryTranslationForeignKeyParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Parser
 */
class EntryTranslationForeignKeyParser
{

    /**
     * Return the translation foreign key attribute.
     *
     * @param StreamInterface $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        return 'protected $translationForeignKey = \'' . str_singular($stream->getSlug()) . '_id' . '\';';
    }
}

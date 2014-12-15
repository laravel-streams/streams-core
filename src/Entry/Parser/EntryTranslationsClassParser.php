<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryTranslationsClassParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Parser
 */
class EntryTranslationsClassParser
{

    /**
     * Return the entry translations model class.
     *
     * @param StreamInterface $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        return studly_case("{$stream->getNamespace()}_{$stream->getSlug()}") . 'EntryTranslationsModel';
    }
}

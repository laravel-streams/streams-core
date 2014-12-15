<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryNamespaceParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Parser
 */
class EntryNamespaceParser
{

    /**
     * Return the entry model base namespace.
     *
     * @param StreamInterface $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        return studly_case($stream->getNamespace());
    }
}

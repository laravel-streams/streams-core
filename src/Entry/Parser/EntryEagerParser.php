<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryEagerParser
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry\Parser
 */
class EntryEagerParser
{

    /**
     * Parse the relation methods.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        $assignments = $stream->getRelationshipAssignments();

        return '[\'' . implode('\', \'', $assignments->fieldSlugs()) . '\']';
    }
}

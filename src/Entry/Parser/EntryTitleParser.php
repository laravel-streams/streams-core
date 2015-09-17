<?php

namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryTitleParser.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry\Parser
 */
class EntryTitleParser
{
    /**
     * Return the title key for an entry model.
     *
     * @param  StreamInterface $stream
     * @return mixed
     */
    public function parse(StreamInterface $stream)
    {
        return $stream->getTitleColumn();
    }
}

<?php

namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryDatesParser.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry\Parser
 */
class EntryDatesParser
{
    /**
     * Return the dates attribute.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        $dates = [];

        $dates[] = "'created_at'";
        $dates[] = "'updated_at'";

        /* @var AssignmentInterface $assignment */
        foreach ($stream->getDateAssignments() as $assignment) {
            $dates[] = "'{$assignment->getFieldSlug()}'";
        }

        if ($stream->isTrashable()) {
            $dates[] = "'deleted_at'";
        }

        return '['.implode(', ', $dates).']';
    }
}

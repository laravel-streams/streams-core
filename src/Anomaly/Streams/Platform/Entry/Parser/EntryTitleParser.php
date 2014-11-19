<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

/**
 * Class EntryTitleParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Parser
 */
class EntryTitleParser
{

    /**
     * Parse the title key for an entry model.
     *
     * @param StreamModel $stream
     * @return mixed
     */
    public function parse(StreamModel $stream)
    {
        return $stream->title_column;
    }
}
 
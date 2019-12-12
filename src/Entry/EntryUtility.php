<?php

namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Command\GenerateEntryModelClassmap;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryUtility
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class EntryUtility
{

    /**
     * Recompile entry models for a given stream.
     *
     * @param StreamInterface $stream
     */
    public function recompile(StreamInterface $stream)
    {
        // Generate the base model.
        EntryGenerator::generate($stream);

        dispatch_now(new GenerateEntryModelClassmap());
    }
}

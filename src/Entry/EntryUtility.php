<?php

namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Command\GenerateEntryModel;
use Anomaly\Streams\Platform\Entry\Command\GenerateEntryModelClassmap;
use Anomaly\Streams\Platform\Entry\Command\GenerateEntryTranslationsModel;
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
        dispatch_now(new GenerateEntryModel($stream));

        /*
         * If the stream is translatable generate
         * the translations model too.
         */
        if ($stream->isTranslatable()) {
            dispatch_now(new GenerateEntryTranslationsModel($stream));
        }

        dispatch_now(new GenerateEntryModelClassmap());
    }
}

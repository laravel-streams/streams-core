<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Laracasts\Commander\CommanderTrait;

/**
 * Class EntryUtility
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry
 */
class EntryUtility
{

    use CommanderTrait;

    /**
     * Recompile entry models for a given stream.
     *
     * @param StreamInterface $stream
     */
    public function recompile(StreamInterface $stream)
    {
        // Generate the base model.
        $this->execute(
            'Anomaly\Streams\Platform\Entry\Command\GenerateEntryModelCommand',
            compact('stream')
        );

        /**
         * If the stream is translatable generate
         * the translations model too.
         */
        if ($stream->isTranslatable()) {
            $this->execute(
                'Anomaly\Streams\Platform\Entry\Command\GenerateEntryTranslationsModelCommand',
                compact('stream')
            );
        }
    }
}

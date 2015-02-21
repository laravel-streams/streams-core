<?php namespace Anomaly\Streams\Platform\Stream\Listener;

use Anomaly\Streams\Platform\Entry\EntryUtility;
use Anomaly\Streams\Platform\Stream\Event\StreamWasSaved;

/**
 * Class CreateTable
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Listener
 */
class Recompile
{

    /**
     * The entry utility.
     *
     * @var \Anomaly\Streams\Platform\Entry\EntryUtility
     */
    protected $utility;

    /**
     * Create a new CreateTable instance.
     *
     * @param EntryUtility $utility
     */
    public function __construct(EntryUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * When a stream is created we have some
     * generation to do. Create the streams
     * table as well as the entry models.
     *
     * @param StreamWasSaved $event
     */
    public function handle(StreamWasSaved $event)
    {
        $this->utility->recompile($event->getStream());
    }
}

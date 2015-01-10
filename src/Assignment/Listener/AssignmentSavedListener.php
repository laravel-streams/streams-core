<?php namespace Anomaly\Streams\Platform\Assignment\Listener;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasSaved;

/**
 * Class AssignmentSavedListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment\Listener
 */
class AssignmentSavedListener
{

    /**
     * When an assignment is saved we
     * need to recompile it's stream.
     *
     * @param AssignmentWasSaved $event
     */
    public function handle(AssignmentWasSaved $event)
    {
        $assignment = $event->getAssignment();

        $stream = $assignment->getStream();

        $stream->compile();
    }
}

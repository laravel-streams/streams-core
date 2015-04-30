<?php namespace Anomaly\Streams\Platform\Assignment\Listener;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasUpdated;

/**
 * Class ChangeTableColumn
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Listener
 */
class ChangeTableColumn
{

    /**
     * @param AssignmentWasUpdated $event
     */
    public function handle(AssignmentWasUpdated $event)
    {
    }
}

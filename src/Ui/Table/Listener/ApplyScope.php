<?php namespace Anomaly\Streams\Platform\Ui\Table\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\QueryHasStarted;

/**
 * Class ApplyScope
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Listener
 */
class ApplyScope
{

    /**
     * Handle the event.
     *
     * @param QueryHasStarted $event
     */
    public function handle(QueryHasStarted $event)
    {
        $table = $event->getTable();
        $query = $event->getQuery();

        $scope = $table->getOption('scope');

        if (!$scope) {
            return;
        }

        if ($scope instanceof \Closure) {
            app()->call($scope, compact('table', 'query'));
        }

        if (is_string($scope) && str_is('*@*', $scope)) {
            app()->call($scope, compact('table', 'query'));
        }
    }
}

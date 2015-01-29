<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\ApplyScope;

/**
 * Class ApplyScopeHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command\Handler
 */
class ApplyScopeHandler
{

    /**
     * Handle the command.
     *
     * @param ApplyScope $command
     */
    public function handle(ApplyScope $command)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

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

<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewHandlerInterface;

/**
 * Class RunTableQueryHookCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Command
 */
class RunTableQueryHookCommandHandler
{

    /**
     * Handle the command.
     *
     * @param RunTableQueryHookCommand $command
     */
    public function handle(RunTableQueryHookCommand $command)
    {
        $event = $command->getEvent();

        $table = $event->getTable();
        $views = $table->getViews();

        if ($view = $views->active()) {
            if ($view instanceof ViewHandlerInterface) {
                $view->onTableQuery($command->getEvent());
            }
        }
    }
}

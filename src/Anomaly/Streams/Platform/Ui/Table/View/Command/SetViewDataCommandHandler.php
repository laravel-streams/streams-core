<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;

/**
 * Class SetViewDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View\Command
 */
class SetViewDataCommandHandler
{
    /**
     * Handle the command.
     *
     * @param SetViewDataCommand $command
     */
    public function handle(SetViewDataCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $views = [];

        foreach ($table->getViews() as $view) {
            if ($view instanceof ViewInterface) {
                $views[] = $view->viewData();
            }
        }

        $table->putData('views', $views);
    }
}

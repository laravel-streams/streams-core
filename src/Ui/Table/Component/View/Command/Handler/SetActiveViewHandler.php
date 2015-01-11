<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\SetActiveView;

/**
 * Class SetActiveViewHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Command
 */
class SetActiveViewHandler
{

    /**
     * Set the active view.
     *
     * @param SetActiveView $command
     */
    public function handle(SetActiveView $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $options = $table->getOptions();
        $views   = $table->getViews();

        if ($view = $views->findBySlug(app('request')->get($options->get('prefix') . 'view'))) {
            $view->setActive(true);
        }

        if (!$view && $view = $views->first()) {
            $view->setActive(true);
        }
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\Table\Multiple\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Multiple\MultipleTableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetActiveActions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Multiple\Command
 */
class SetActiveActions implements SelfHandling
{

    /**
     * The multiple form builder.
     *
     * @var MultipleTableBuilder
     */
    protected $builder;

    /**
     * Create a new MergeRows instance.
     *
     * @param MultipleTableBuilder $builder
     */
    public function __construct(MultipleTableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $actions = $this->builder->getTableActions();

        if (!$action = $actions->active()) {
            return;
        }

        foreach ($this->builder->getTables() as $builder) {
            $this->setActiveAction($action->getSlug(), $builder);
        }
    }

    /**
     * Set the active action.
     *
     * @param              $slug
     * @param TableBuilder $builder
     */
    protected function setActiveAction($slug, TableBuilder $builder)
    {
        /* @var ActionInterface $action */
        foreach ($builder->getTableActions() as $action) {
            if ($action->getSlug() === $slug) {

                $action->setPrefix($builder->getTableOption('prefix'));
                $action->setActive(true);

                break;
            }
        }
    }
}

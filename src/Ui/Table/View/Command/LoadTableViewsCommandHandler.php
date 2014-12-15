<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

use Anomaly\Streams\Platform\Ui\Table\View\ViewFactory;

/**
 * Class LoadTableViewsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View\Command
 */
class LoadTableViewsCommandHandler
{

    /**
     * The view factory.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\View\ViewFactory
     */
    protected $factory;

    /**
     * Create a new LoadTableViewsCommandHandler instance.
     *
     * @param ViewFactory $factory
     */
    public function __construct(ViewFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle the command.
     *
     * @param LoadTableViewsCommand $command
     */
    public function handle(LoadTableViewsCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $views   = $table->getViews();

        $activeView = app('request')->get($table->getPrefix() . 'view');

        foreach ($builder->getViews() as $k => $parameters) {
            $view = $this->factory->make($parameters);

            $view->setPrefix($table->getPrefix());

            if ($activeView == $view->getSlug() || (!$activeView && $k == 0)) {
                $view->setActive(true);
            }

            $views->put($view->getSlug(), $view);
        }
    }
}

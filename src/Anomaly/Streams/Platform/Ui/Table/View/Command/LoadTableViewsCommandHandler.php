<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

use Anomaly\Streams\Platform\Ui\Table\View\ViewFactory;

class LoadTableViewsCommandHandler
{

    protected $factory;

    function __construct(ViewFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(LoadTableViewsCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $views   = $table->getViews();

        $activeView = app('request')->get($table->getPrefix() . 'view');

        foreach ($builder->getViews() as $k => $parameters) {

            $view = $this->factory->make($parameters);

            $view->setPrefix($table->getPrefix());

            if ($activeView == $view->getSlug() or $k == 0) {

                $view->setActive(true);
            }

            $views->put($view->getSlug(), $view);
        }
    }
}
 
<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;

class SetViewDataCommandHandler
{

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
 
<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Laracasts\Commander\CommanderTrait;

class ParseBuilderInputCommandHandler
{

    use CommanderTrait;

    public function handle(ParseBuilderInputCommand $command)
    {
        $builder = $command->getBuilder();

        $views   = $builder->getViews();
        $filters = $builder->getFilters();
        $columns = $builder->getColumns();
        $buttons = $builder->getButtons();
        $actions = $builder->getActions();

        $views = $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\View\Command\ParseViewInputCommand',
            compact('views')
        );

        $filters = $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Filter\Command\ParseFilterInputCommand',
            compact('filters')
        );

        $columns = $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Column\Command\ParseColumnInputCommand',
            compact('columns')
        );

        $buttons = $this->execute(
            'Anomaly\Streams\Platform\Ui\Button\Command\ParseButtonInputCommand',
            compact('buttons')
        );

        $actions = $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Action\Command\ParseActionInputCommand',
            compact('actions')
        );

        $builder->setViews($views);
        $builder->setFilters($filters);
        $builder->setColumns($columns);
        $builder->setButtons($buttons);
        $builder->setActions($actions);
    }
}
 
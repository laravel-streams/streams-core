<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TableDataLoaded;
use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;
use Laracasts\Commander\Events\DispatchableTrait;

class MakeTableCommandHandler
{

    use DispatchableTrait;

    public function handle(MakeTableCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $this->setRowData($table);
        $this->setViewData($table);
        $this->setFilterData($table);
        $this->setButtonData($table);
        $this->setActionData($table);

        $table->raise(new TableDataLoaded($table));

        $this->dispatchEventsFor($table);

        $table->setContent(view($table->getView(), $table->getData()));
    }

    protected function setRowData(Table $table)
    {
        $rows = [];

        $table->putData('rows', $rows);
    }

    protected function setViewData(Table $table)
    {
        $views = [];

        foreach ($table->getViews() as $view) {

            if ($view instanceof ViewInterface) {

                $views[] = $view->viewData();
            }
        }

        $table->putData('views', $views);
    }

    protected function setFilterData(Table $table)
    {
        $filters = [];

        foreach ($table->getFilters() as $filter) {

            if ($filter instanceof FilterInterface) {

                $filters[] = $filter->viewData();
            }
        }

        $table->putData('filters', $filters);
    }

    protected function setButtonData(Table $table)
    {
        $buttons = [];

        foreach ($table->getButtons() as $button) {

            if ($button instanceof ButtonInterface) {

                $buttons[] = $button->viewData();
            }
        }

        $table->putData('buttons', $buttons);
    }

    protected function setActionData(Table $table)
    {
        $actions = [];

        foreach ($table->getActions() as $action) {

            if ($action instanceof ActionInterface) {

                $actions[] = $action->viewData();
            }
        }

        $table->putData('actions', $actions);
    }
}
 
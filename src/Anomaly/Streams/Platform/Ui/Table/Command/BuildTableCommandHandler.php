<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Table\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Column\ColumnCollection;
use Anomaly\Streams\Platform\Ui\Table\Column\Contract\ColumnInterface;
use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Filter\FilterCollection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;
use Anomaly\Streams\Platform\Ui\Table\View\ViewCollection;
use Laracasts\Commander\CommanderTrait;

class BuildTableCommandHandler
{

    use CommanderTrait;

    public function handle(BuildTableCommand $command)
    {
        $builder = $command->getBuilder();

        $this->loadTableViews($builder);
        $this->loadTableFilters($builder);
        $this->loadTableColumns($builder);
        $this->loadTableButtons($builder);
        $this->loadTableActions($builder);

        die('Oh hai!');
    }

    protected function loadTableViews(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $views = $table->getViews();

        foreach ($builder->getViews() as $parameters) {

            $view = $this->execute(
                'Anomaly\Streams\Platform\Ui\Table\View\Command\MakeViewCommand',
                compact('parameters')
            );

            $view->setPrefix($table->getPrefix());

            $this->loadTableView($views, $view);
        }
    }

    protected function loadTableView(ViewCollection $views, ViewInterface $view)
    {
        $views->put($view->getSlug(), $view);
    }

    protected function loadTableFilters(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $filters = $table->getFilters();

        foreach ($builder->getFilters() as $parameters) {

            $filter = $this->execute(
                'Anomaly\Streams\Platform\Ui\Table\Filter\Command\MakeFilterCommand',
                compact('parameters')
            );

            $filter->setPrefix($table->getPrefix());

            $this->loadTableFilter($filters, $filter);
        }
    }

    protected function loadTableFilter(FilterCollection $filters, FilterInterface $filter)
    {
        $filters->put($filter->getSlug(), $filter);
    }

    protected function loadTableColumns(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $columns = $table->getColumns();

        foreach ($builder->getColumns() as $parameters) {

            $column = $this->execute(
                'Anomaly\Streams\Platform\Ui\Table\Column\Command\MakeColumnCommand',
                compact('parameters')
            );

            $column->setPrefix($table->getPrefix());

            $this->loadTableColumn($columns, $column);
        }
    }

    protected function loadTableColumn(ColumnCollection $columns, ColumnInterface $column)
    {
        $columns->push($column);
    }

    protected function loadTableButtons(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $buttons = $table->getButtons();

        foreach ($builder->getButtons() as $parameters) {

            $button = $this->execute(
                'Anomaly\Streams\Platform\Ui\Button\Command\MakeButtonCommand',
                compact('parameters')
            );

            $button->setSize('sm');

            $this->loadTableButton($buttons, $button);
        }
    }

    protected function loadTableButton(ButtonCollection $buttons, ButtonInterface $button)
    {
        $buttons->push($button);
    }

    protected function loadTableActions(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $actions = $table->getActions();

        foreach ($builder->getActions() as $parameters) {

            $action = $this->execute(
                'Anomaly\Streams\Platform\Ui\Table\Action\Command\MakeActionCommand',
                compact('parameters')
            );

            $action->setPrefix($table->getPrefix());

            $this->loadTableAction($actions, $action);
        }
    }

    protected function loadTableAction(ActionCollection $actions, ActionInterface $action)
    {
        $actions->put($action->getSlug(), $action);
    }
}
 
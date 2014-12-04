<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TableIsBuilding;
use Anomaly\Streams\Platform\Ui\Table\Event\TableWasBuilt;
use Anomaly\Streams\Platform\Ui\Table\Exception\IncompatibleModelException;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\DispatchableTrait;

class BuildTableCommandHandler
{

    use CommanderTrait;
    use DispatchableTrait;

    public function handle(BuildTableCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $table->raise(new TableIsBuilding($builder));

        $this->dispatchEventsFor($table);

        $this->loadTableEntries($builder); // Do this first

        $this->loadTableViews($builder);
        $this->loadTableFilters($builder);
        $this->loadTableColumns($builder);
        $this->loadTableButtons($builder);
        $this->loadTableActions($builder);

        $table->raise(new TableWasBuilt($table));

        $this->dispatchEventsFor($table);

        $this->loadTableRows($builder);
    }

    protected function loadTableEntries(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $class   = $builder->getModel();
        $entries = $table->getEntries();

        $model = app($class);

        if (!$model instanceof TableModelInterface) {

            throw new IncompatibleModelException("[$class] must implement Anomaly\\Streams\\Platform\\Ui\\Table\\Contract\\TableModelInterface");
        }

        /**
         * If the model can extract a Stream then
         * set it on the table at this time so we
         * can use it later if we need.
         *
         * I do not like using the table as a
         * transport like this but it may be needed
         * for the time being. And perhaps not such
         * a bad idea either. The events carrying the
         * table object may very well benefit from it.
         */
        if ($model instanceof EntryInterface) {

            $table->setStream($model->getStream());
        }

        foreach ($model->getTableEntries($table) as $entry) {

            $entries->push($entry);
        }
    }

    protected function loadTableViews(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $views = $table->getViews();

        $activeView = app('request')->get($table->getPrefix() . 'view');

        foreach ($builder->getViews() as $k => $parameters) {

            $view = $this->execute(
                'Anomaly\Streams\Platform\Ui\Table\View\Command\MakeViewCommand',
                compact('parameters')
            );

            $view->setPrefix($table->getPrefix());

            if ($activeView == $view->getSlug() or $k == 0) {

                $view->setActive(true);
            }

            $views->put($view->getSlug(), $view);
        }
    }

    protected function loadTableFilters(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $filters = $table->getFilters();

        foreach ($builder->getFilters() as $parameters) {

            array_set($parameters, 'stream', $table->getStream());

            $filter = $this->execute(
                'Anomaly\Streams\Platform\Ui\Table\Filter\Command\MakeFilterCommand',
                compact('parameters')
            );

            $filter->setPrefix($table->getPrefix());

            $filters->put($filter->getSlug(), $filter);
        }
    }

    protected function loadTableColumns(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $columns = $table->getColumns();

        foreach ($builder->getColumns() as $parameters) {

            array_set($parameters, 'stream', $table->getStream());

            $column = $this->execute(
                'Anomaly\Streams\Platform\Ui\Table\Column\Command\MakeColumnCommand',
                compact('parameters')
            );

            $column->setPrefix($table->getPrefix());

            $columns->push($column);
        }
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

            $buttons->push($button);
        }
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

            $actions->put($action->getSlug(), $action);
        }
    }

    protected function loadTableRows(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $entries = $table->getEntries();
        $columns = $table->getColumns();
        $buttons = $table->getButtons();
        $rows    = $table->getRows();

        foreach ($entries as $entry) {

            $row = $this->execute(
                'Anomaly\Streams\Platform\Ui\Table\Row\Command\MakeRowCommand',
                compact('entry', 'columns', 'buttons')
            );

            $rows->push($row);
        }
    }
}
 
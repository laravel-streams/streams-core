<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Button\ButtonReader;
use Anomaly\Streams\Platform\Ui\Table\Action\ActionReader;
use Anomaly\Streams\Platform\Ui\Table\Column\ColumnReader;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Anomaly\Streams\Platform\Ui\Table\Exception\IncompatibleModelException;
use Anomaly\Streams\Platform\Ui\Table\Filter\FilterReader;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\View\ViewReader;

class StandardizeInputCommandHandler
{

    protected $viewReader;

    protected $filterReader;

    protected $columnReader;

    protected $buttonReader;

    protected $actionReader;

    function __construct(
        ViewReader $viewReader,
        FilterReader $filterReader,
        ColumnReader $columnReader,
        ButtonReader $buttonReader,
        ActionReader $actionReader
    ) {
        $this->viewReader   = $viewReader;
        $this->filterReader = $filterReader;
        $this->columnReader = $columnReader;
        $this->buttonReader = $buttonReader;
        $this->actionReader = $actionReader;
    }

    public function handle(StandardizeInputCommand $command)
    {
        $builder = $command->getBuilder();

        $this->standardizeModelInput($builder);

        $this->standardizeViewInput($builder);
        $this->standardizeFilterInput($builder);
        $this->standardizeColumnInput($builder);
        $this->standardizeButtonInput($builder);
        $this->standardizeActionInput($builder);
    }

    protected function standardizeViewInput(TableBuilder $builder)
    {
        $views = $builder->getViews();

        foreach ($views as $key => &$view) {

            $view = $this->viewReader->convert($key, $view);
        }

        $builder->setViews(array_values($views));
    }

    protected function standardizeFilterInput(TableBuilder $builder)
    {
        $filters = $builder->getFilters();

        foreach ($filters as $key => &$filter) {

            $filter = $this->filterReader->convert($key, $filter);
        }

        $builder->setFilters(array_values($filters));
    }

    protected function standardizeColumnInput(TableBuilder $builder)
    {
        $columns = $builder->getColumns();

        foreach ($columns as $key => &$column) {

            $column = $this->columnReader->convert($key, $column);
        }

        $builder->setColumns(array_values($columns));
    }

    protected function standardizeButtonInput(TableBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {

            $button = $this->buttonReader->convert($key, $button);
        }

        $builder->setButtons(array_values($buttons));
    }

    protected function standardizeActionInput(TableBuilder $builder)
    {
        $actions = $builder->getActions();

        foreach ($actions as $key => &$action) {

            $action = $this->actionReader->convert($key, $action);
        }

        $builder->setActions(array_values($actions));
    }

    protected function standardizeModelInput(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $class = $builder->getModel();

        $model = app($class);

        /**
         * If the model can extract a Stream then
         * set it on the table at this time so we
         * can use it later if we need.
         */
        if ($model instanceof EntryInterface) {

            $table->setStream($model->getStream());
        }

        if (!$model instanceof TableModelInterface) {

            throw new IncompatibleModelException("[$class] must implement Anomaly\\Streams\\Platform\\Ui\\Table\\Contract\\TableModelInterface");
        }

        $builder->setModel($model);
    }
}
 
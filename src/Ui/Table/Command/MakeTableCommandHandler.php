<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Column\Contract\ColumnInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TableDataLoaded;
use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;
use Anomaly\Streams\Platform\Ui\Table\Row\Contract\RowInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;
use Illuminate\Pagination\LengthAwarePaginator;
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
        $this->setActionData($table);
        $this->setHeaderData($table);
        $this->setTableData($table);
        $this->setPaginationData($table);

        $table->raise(new TableDataLoaded($table));

        $this->dispatchEventsFor($table);

        $table->setContent(view($table->getView(), $table->getData()));
    }

    protected function setRowData(Table $table)
    {
        $rows = [];

        foreach ($table->getRows() as $row) {

            if ($row instanceof RowInterface) {

                $rows[] = $row->viewData();
            }
        }

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

    protected function setHeaderData(Table $table)
    {
        $headers = [];

        foreach ($table->getColumns() as $column) {

            if ($column instanceof ColumnInterface) {

                if ($header = $column->getHeader() and $header instanceof HeaderInterface) {

                    $headers[] = $header->viewData();
                }
            }
        }

        $table->putData('headers', $headers);
    }

    protected function setTableData(Table $table)
    {
        $table->putData('prefix', $table->getPrefix());
        $table->putData('sortable', $table->isSortable());
        $table->putData('filtering', ($table->getFilters()->active()->count()));
        $table->putData('noResultsMessage', trans($table->getNoResultsMessage()));
    }

    protected function setPaginationData(Table $table)
    {
        $perPage   = $table->getLimit();
        $page      = app('request')->get('page');
        $path      = '/' . app('request')->path();
        $paginator = new LengthAwarePaginator(
            $table->getEntries(),
            $table->getTotal(),
            $perPage,
            $page,
            compact('path')
        );

        $pagination          = $paginator->toArray();
        $pagination['links'] = $paginator->appends($_GET)->render();

        $table->putData('pagination', $pagination);
    }
}
 
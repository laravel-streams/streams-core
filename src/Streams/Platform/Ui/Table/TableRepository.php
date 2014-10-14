<?php namespace Streams\Platform\Ui\Table;

use Illuminate\Database\Eloquent\Builder;
use Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;

class TableRepository implements TableRepositoryInterface
{
    protected $ui;

    protected $model;

    function __construct(TableUi $ui, $model = null)
    {
        $this->ui    = $ui;
        $this->model = $model;
    }

    public function get()
    {
        $query = $this->model->newInstance();

        if ($result = $this->ui->fire('query', [$query]) and $result instanceof Builder) {
            $query = $result;
        }

        // Do other logic here.

        $entries = $query->get();

        return $entries;
    }
}
 
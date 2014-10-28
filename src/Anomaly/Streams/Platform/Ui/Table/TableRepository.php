<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;

class TableRepository implements TableRepositoryInterface
{
    protected $ui;

    protected $model;

    function __construct(TableUi $ui, EloquentModel $model = null)
    {
        $this->ui    = $ui;
        $this->model = $model;
    }

    public function get()
    {
        $query = $this->model->newInstance();

        $this->ui->fire('query', [&$query]);

        // Do other logic here.

        $entries = $query->get();

        return $entries;
    }
}
 
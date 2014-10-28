<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;

/**
 * Class TableRepository
 *
 * This class provides entry data for the TableUi class
 * in a way that can be replicated with another provider
 * like a 3rd party API service.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableRepository implements TableRepositoryInterface
{
    /**
     * The table UI object.
     *
     * @var TableUi
     */
    protected $ui;

    /**
     * The model object if any.
     *
     * @var \Anomaly\Streams\Platform\Model\EloquentModel
     */
    protected $model;

    /**
     * Create a new TableRepository instance.
     *
     * @param TableUi       $ui
     * @param EloquentModel $model
     */
    function __construct(TableUi $ui, EloquentModel $model = null)
    {
        $this->ui    = $ui;
        $this->model = $model;
    }

    /**
     * Return a Collection of EntryInterface objects
     * based on the configuration in the UI object.
     *
     * @return mixed
     */
    public function get()
    {
        $query = $this->model->newInstance();

        $this->ui->fire('query', [&$query]);

        // Do other logic here.

        $entries = $query->get();

        return $entries;
    }

    /**
     * Get the total number of matching entries.
     *
     * @return integer
     */
    public function total()
    {
        $query = $this->model->newInstance();

        $this->ui->fire('query', [&$query]);

        return $query->total();
    }

}
 
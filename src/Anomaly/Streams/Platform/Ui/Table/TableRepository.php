<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Support\Paginator;
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
     * The request object.
     *
     * @var mixed
     */
    protected $request;

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

        $this->request = app('request');
    }

    /**
     * Return a Collection of EntryInterface objects
     * based on the configuration in the UI object.
     *
     * Any pagination / query logic needs to be either
     * done here or trigger / fired from here in
     * order to keep a cohesive request.
     *
     * @return mixed
     */
    public function get()
    {
        $query = $this->model->newInstance();

        /**
         * This hook is used for views / actions
         * and any other query hooks the developer
         * want's to implement.
         */
        $this->ui->fire('query', [&$query]);

        /**
         * Save the total of the basic query
         * after hooks but before paging.
         */
        $total = $query->count();

        // Make sure the page exists.
        $this->assurePageExists($total);

        /**
         * Return only the page's entries based
         * on configured limit and the current page.
         */
        $limit  = $this->ui->getLimit();
        $offset = $limit * ($this->request->get('page', 1) - 1);

        $query = $query->take($limit)->offset($offset);

        /**
         * Finally get the resulting entries.
         */
        $entries = $query->get();

        /**
         * Build a paginator to use later.
         */
        $this->makePagination($total);

        return $entries;
    }

    /**
     * Make the pagination and set it on the
     * table UI object to be used later.
     *
     * @param $total
     */
    protected function makePagination($total)
    {
        $request = app('request');

        $items   = [];
        $page    = $request->get('page');
        $perPage = $this->ui->getLimit();
        $path    = '/' . $request->path();

        $paginator = new Paginator($items, $total, $perPage, $page, compact('path'));

        $this->ui->setPaginator($paginator);
    }

    protected function assurePageExists($total)
    {
        $limit  = $this->ui->getLimit();
        $page   = $this->request->get('page', 1);
        $offset = $limit * ($page - 1);

        if ($total < $offset and $page > 1) {

            header('Location: ' . url(app('request')->path()) . '/?page=' . ($page - 1));

        }
    }

}
 
<?php namespace Streams\Core\Ui\Entry;

use Streams\Core\Ui\TableUi;

class EntryRepository
{
    /**
     * The UI object.
     *
     * @var \Streams\Core\Ui\TableUi
     */
    protected $ui;

    /**
     * Create a new EntryRepository instance.
     *
     * @param $ui
     */
    public function __construct(TableUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Return the desired entries.
     *
     * @return mixed
     */
    public function get()
    {
        $model = $this->ui->getModel();

        $paginator = $this->ui->getPaginator();

        $limit  = $this->ui->getLimit($paginator->getPerPage());
        $offset = ($paginator->getFrom() - 1) * $limit;

        return $model
            ->take($limit)
            ->skip($offset)
            ->get();
    }

    /**
     * Return the total number of entries.
     *
     * @return mixed
     */
    public function total()
    {
        return $this->ui->getModel()->count();
    }
}

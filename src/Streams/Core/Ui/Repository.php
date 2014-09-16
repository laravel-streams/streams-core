<?php namespace Streams\Core\Ui;

use Streams\Core\Ui\TableUi;

class Repository
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

        //$paginator = $this->ui->getPaginator();

        //$limit   = $this->ui->getLimit($paginator->getPerPage());
        //$offset  = ($paginator->getCurrentPage() - 1) * $limit;
        $orderBy = $this->ui->getOrderBy();
        $sort    = $this->ui->getSort();

        $query = $model
            //->take($limit)
            //->skip($offset)
            ->orderBy($orderBy, $sort);

        return $query->get();
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

    /**
     * Return the desired entry.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->ui->getModel()->find($id);
    }

    /**
     * Return a new entry.
     *
     * @return mixed
     */
    public function newEntry()
    {
        return $this->ui->getModel()->newInstance();
    }

    /**
     * Process the form submission.
     *
     * @return mixed
     */
    public function save()
    {
        $entry = $this->ui->getEntry();

        foreach ($entry->getStream()->assignments as $assignment) {
            $field = $assignment->field;
            $type  = $field->type;

            if (\Input::has($type->fieldName())) {
                $entry->{$field->slug} = \Input::get($type->fieldName());
            }
        }

        if ($entry->save()) {
            \Messages::add('success', trans('**Success** Perfect!'));
        } else {
            foreach ($entry->errors()->all() as $message) {
                \Messages::add('error', trans('**Error** ' . $message));
            }
        }

        return $entry;
    }
}

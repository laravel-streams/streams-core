<?php namespace Streams\Core\Ui\Support;

use Streams\Core\Ui\UiAbstract;
use Illuminate\Database\Eloquent\Builder;

class Repository
{
    /**
     * The UI object.
     *
     * @var \Streams\Core\Ui\UiAbstract
     */
    protected $ui;

    /**
     * Create a new Repository instance.
     *
     * @param UiAbstract $ui
     */
    public function __construct(UiAbstract $ui)
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

        $view = $this->ui->views()->active();

        $filters = $this->ui->filters();

        //$paginator = $this->ui->getPaginator();

        //$limit   = $this->ui->getLimit($paginator->getPerPage());
        //$offset  = ($paginator->getCurrentPage() - 1) * $limit;
        $orderBy = $this->ui->getOrderBy();
        $sort    = $this->ui->getSort();

        $query = $model
            //->take($limit)
            //->skip($offset)
            ->orderBy($orderBy, $sort);

        $result = $view->fire('query', [$query]);

        if ($result instanceof Builder) {
            $query = $result;
        }

        foreach ($filters as $filter) {
            if ($filter->getValue()) {
                $result = $filter->query($query);

                if ($result instanceof Builder) {
                    $query = $result;
                }
            }
        }

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
        $entry  = $this->ui->getEntry();
        $action = $this->ui->actions()->active();

        foreach ($entry->getStream()->assignments as $assignment) {
            $field = $assignment->field;
            $type  = $field->type;

            if (!in_array($type->fieldName(), $this->ui->getSkips())) {
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

        $action->redirect($entry);

        return $entry;
    }
}

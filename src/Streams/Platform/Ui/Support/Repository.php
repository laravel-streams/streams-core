<?php namespace Streams\Platform\Ui\Support;

use Streams\Platform\Ui\UiAbstract;
use Illuminate\Database\Eloquent\Builder;

class Repository
{
    /**
     * The UI object.
     *
     * @var \Streams\Platform\Ui\UiAbstract
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

        if ($view) {
            $result = $view->fire('query', [$model]);
        }

        if (isset($result) and $result instanceof Builder) {
            $query = $result;
        } else {
            $query = $model;
        }

        $total = $query->count();

        $filters = $this->ui->filters();

        $paginator = $this->ui->newPaginator()->make([], $total, $this->ui->getLimit());

        $this->ui->setPaginator($paginator);

        $limit  = $paginator->getPerPage();
        $offset = ($paginator->getCurrentPage() - 1) * $limit;

        $query = $query->take($limit)->skip($offset);

        foreach ($this->ui->getOrderBy() as $orderBy) {
            $query = $query->orderBy($orderBy['column'], $orderBy['direction']);
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

        $messages = app('streams.messages');

        foreach ($entry->getStream()->assignments as $assignment) {
            $type  = $assignment->fieldType();
            $field = $assignment->field;

            $type->setEntry($entry)->setAssignment($assignment);

            if (!in_array($type->fieldName(), $this->ui->getSkips())) {
                $entry->{$field->slug} = \Input::get($type->fieldName());
            }
        }

        if ($entry->save()) {
            $messages->add('success', trans('**Success** Perfect!'));
        } else {
            foreach ($entry->errors()->all() as $message) {
                $messages->add('error', trans('**Error** ' . $message));
            }
        }

        $action->redirect($entry);

        return $entry;
    }
}

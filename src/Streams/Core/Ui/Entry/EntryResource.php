<?php namespace Streams\Core\Ui\Entry;

class EntryResource
{
    /**
     * The UI object.
     *
     * @var
     */
    protected $ui;

    /**
     * Create a new EntryRepository instance.
     *
     * @param $ui
     */
    public function __construct($ui)
    {
        $this->ui = $ui;
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

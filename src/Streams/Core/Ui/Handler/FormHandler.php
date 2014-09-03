<?php namespace Streams\Core\Ui\Handler;

use Streams\Core\Ui\FormUi;

class FormHandler
{
    /**
     * The form UI object.
     *
     * @var
     */
    protected $ui;

    /**
     * Create a new FormHandler instance.
     *
     * @param FormUi $ui
     */
    public function __construct(FormUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Process the form submission.
     *
     * @return mixed
     */
    public function save()
    {
        $model = $this->ui->getModel();

        $assignments = $model->getStream()->assignments;

        if (!$entry = $this->ui->getEntry()) {
            $entry = new $model;
        }

        foreach ($assignments as $assignment) {
            $type = $assignment->field->type
                ->setAssignment($assignment)
                ->setEntry($entry);

            $entry->{$type->columnName()} = $type->value();
        }

        if ($entry->save()) {
            \Messages::add('success', \Lang::trans('**Success** Perfect!'));
        } else {
            foreach ($entry->errors()->all() as $message) {
                \Messages::add('error', \Lang::trans('**Error** ' . $message));
            }
        }

        return $entry;
    }
}

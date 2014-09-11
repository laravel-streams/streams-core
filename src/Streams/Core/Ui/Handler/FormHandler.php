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
        $entry = $this->ui->getEntry();

        foreach ($entry->getStream()->assignments as $assignment) {
            $field = $assignment->field;
            $type  = $field->type;

            $entry->{$field->slug} = \Input::get($type->fieldName());
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

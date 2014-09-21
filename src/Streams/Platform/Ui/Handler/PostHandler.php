<?php namespace Streams\Platform\Ui\Handler;

use Streams\Platform\Ui\FormUi;

class PostHandler
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
    public function data()
    {

    }
}

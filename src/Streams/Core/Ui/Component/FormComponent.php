<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\FormUi;

class FormComponent extends Component
{
    /**
     * The TableUi object.
     *
     * @var \Streams\Ui\FormUi
     */
    protected $ui;

    /**
     * Create a new FormComponent instance.
     *
     * @param FormUi $ui
     */
    public function __construct(FormUi $ui = null)
    {
        $this->ui = $ui;
    }
}

<?php namespace Streams\Platform\Ui\Builder;

use Streams\Platform\Ui\FormUi;

abstract class FormBuilderAbstract extends BuilderAbstract
{
    /**
     * The UI object.
     *
     * @var array
     */
    protected $ui;

    /**
     * Create a new FormBuilderAbstract instance.
     *
     * @param FormUi $ui
     */
    public function __construct(FormUi $ui)
    {
        $this->ui = $ui;
    }
}

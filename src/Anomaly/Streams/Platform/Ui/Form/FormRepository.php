<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;

class FormRepository implements FormRepositoryInterface
{
    protected $ui;

    protected $model;

    function __construct(FormUi $ui, $model = null)
    {
        $this->ui    = $ui;
        $this->model = $model;
    }

    public function get()
    {
        //
    }

    public function store()
    {
        //
    }
}
 
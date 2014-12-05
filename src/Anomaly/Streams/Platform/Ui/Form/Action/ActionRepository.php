<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

class ActionRepository
{

    protected $actions = [];

    public function find($action)
    {
        return array_get($this->actions, $action);
    }
}
 
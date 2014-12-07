<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionRepositoryInterface;

class ActionRepository implements ActionRepositoryInterface
{

    protected $actions = [];

    public function find($action)
    {
        return array_get($this->actions, $action);
    }
}
 
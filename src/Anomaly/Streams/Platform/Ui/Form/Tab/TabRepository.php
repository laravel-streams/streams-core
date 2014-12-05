<?php namespace Anomaly\Streams\Platform\Ui\Form\Tab;

use Anomaly\Streams\Platform\Ui\Form\Tab\Contract\TabRepositoryInterface;

class TabRepository implements TabRepositoryInterface
{

    protected $tabs = [];

    public function find($tab)
    {
        return array_get($this->tabs, $tab);
    }
}
 
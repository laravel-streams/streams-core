<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewRepositoryInterface;

class ViewRepository implements ViewRepositoryInterface
{

    protected $views = [
        'all' => [
            'slug' => 'all',
            'text' => 'misc.all',
            'view' => 'Anomaly\Streams\Platform\Ui\Table\View\View',
        ]
    ];

    public function find($view)
    {
        return array_get($this->views, $view);
    }
}
 
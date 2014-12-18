<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewRepositoryInterface;

/**
 * Class ViewRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewRepository implements ViewRepositoryInterface
{

    /**
     * Available views.
     *
     * @var array
     */
    protected $views = [
        'all' => [
            'slug' => 'all',
            'text' => 'streams::misc.all',
            'view' => 'Anomaly\Streams\Platform\Ui\Table\View\Type\ViewAll',
        ]
    ];

    /**
     * Find a view.
     *
     * @param  $view
     * @return mixed
     */
    public function find($view)
    {
        return array_get($this->views, $view);
    }
}

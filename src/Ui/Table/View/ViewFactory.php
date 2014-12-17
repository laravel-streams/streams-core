<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;
use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewRepositoryInterface;

/**
 * Class ViewFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewFactory
{

    /**
     * The default view class.
     *
     * @var string
     */
    protected $view = 'Anomaly\Streams\Platform\Ui\Table\View\View';

    /**
     * The view repository.
     *
     * @var ViewRepositoryInterface
     */
    protected $views;

    /**
     * Create a new ViewFactory instance.
     *
     * @param ViewRepositoryInterface $views
     */
    function __construct(ViewRepositoryInterface $views)
    {
        $this->views = $views;
    }

    /**
     * Make a view.
     *
     * @param array $parameters
     * @return ViewInterface
     */
    public function make(array $parameters)
    {
        if ($view = $this->views->find(array_get($parameters, 'view'))) {
            $parameters = array_replace_recursive($view, array_except($parameters, 'view'));
        }

        return app()->make(array_get($parameters, 'view', $this->view), $parameters);
    }
}

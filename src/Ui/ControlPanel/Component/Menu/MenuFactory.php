<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu;

use Anomaly\Streams\Platform\Support\Hydrator;

/**
 * Class MenuFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu
 */
class MenuFactory
{

    /**
     * The default menu class.
     *
     * @var string
     */
    protected $menu = Menu::class;

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * Create a new MenuFactory instance.
     *
     * @param Hydrator $hydrator
     */
    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * Make the menu from it's parameters.
     *
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        $menu = app()->make(array_get($parameters, 'menu', $this->menu), $parameters);

        $this->hydrator->hydrate($menu, $parameters);

        return $menu;
    }
}

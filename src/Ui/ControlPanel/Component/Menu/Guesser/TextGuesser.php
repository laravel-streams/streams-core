<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class TextGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Guesser
 */
class TextGuesser
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new TextGuesser instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(ModuleCollection $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Guess the menus text.
     *
     * @param ControlPanelBuilder $builder
     */
    public function guess(ControlPanelBuilder $builder)
    {
        $menus = $builder->getMenu();

        foreach ($menus as &$menu) {

            // If text is set then skip it.
            if (isset($menu['text'])) {
                return;
            }

            $module = $this->modules->active();

            $menu['text'] = $module->getNamespace('addon.menu.' . $menu['slug']);
        }

        $builder->setMenu($menus);
    }
}

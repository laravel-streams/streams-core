<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

class PermissionGuesser
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
        $module = $this->modules->active();

        $menus = $builder->getMenu();

        foreach ($menus as &$menu) {

            // If permission is set then skip it.
            if (isset($menu['permission'])) {
                return;
            }

            $menu['permission'] = $module->getNamespace($menu['slug'] . '.*');
        }

        $builder->setMenu($menus);
    }
}

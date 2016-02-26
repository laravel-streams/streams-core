<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class MenuNormalizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu
 */
class MenuNormalizer
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new MenuNormalizer instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(ModuleCollection $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Normalize the menu input.
     *
     * @param ControlPanelBuilder $builder
     */
    public function normalize(ControlPanelBuilder $builder)
    {
        $menus = $builder->getMenu();

        /**
         * Loop over each menu and make sense of the input
         * provided for the given module.
         */
        foreach ($menus as $slug => &$menu) {

            /**
             * If the slug is not valid and the menu
             * is a string then use the menu as the slug.
             */
            if (is_numeric($slug) && is_string($menu)) {
                $menu = [
                    'slug' => $menu
                ];
            }

            /**
             * If the slug is a string and the text is not
             * set then use the slug as the slug.
             */
            if (is_string($slug) && !isset($menu['slug'])) {
                $menu['slug'] = $slug;
            }

            /**
             * Make sure we have attributes.
             */
            $menu['attributes'] = array_get($menu, 'attributes', []);

            /**
             * Move the HREF into attributes.
             */
            if (isset($menu['href'])) {
                $menu['attributes']['href'] = array_pull($menu, 'href');
            }

            /**
             * Make sure the HREF is absolute.
             */
            if (
                isset($menu['attributes']['href']) &&
                is_string($menu['attributes']['href']) &&
                !starts_with($menu['attributes']['href'], 'http')
            ) {
                $menu['attributes']['href'] = url($menu['attributes']['href']);
            }
        }

        $builder->setMenu(array_values($menus));
    }
}

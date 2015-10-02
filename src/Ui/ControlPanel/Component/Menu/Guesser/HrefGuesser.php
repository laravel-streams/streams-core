<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Routing\UrlGenerator;

/**
 * Class HrefGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Guesser
 */
class HrefGuesser
{

    /**
     * The URL generator.
     *
     * @var UrlGenerator
     */
    protected $url;

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new HrefGuesser instance.
     *
     * @param ModuleCollection $modules
     * @param UrlGenerator     $url
     */
    public function __construct(ModuleCollection $modules, UrlGenerator $url)
    {
        $this->url     = $url;
        $this->modules = $modules;
    }

    /**
     * Guess the menus HREF attribute.
     *
     * @param ControlPanelBuilder $builder
     */
    public function guess(ControlPanelBuilder $builder)
    {
        $menus = $builder->getMenu();

        foreach ($menus as $index => &$menu) {

            // If HREF is set then skip it.
            if (isset($menu['attributes']['href'])) {
                continue;
            }

            $module = $this->modules->active();

            $href = $this->url->to('admin/' . $module->getSlug());

            if ($index !== 0 && $module->getSlug() !== $menu['slug']) {
                $href .= '/' . $menu['slug'];
            }

            $menu['attributes']['href'] = $href;
        }

        $builder->setMenu($menus);
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Command;

use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Contract\MenuItemInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

/**
 * Class SetActiveMenu
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Command
 */
class SetActiveMenu implements SelfHandling
{

    /**
     * The control_panel builder.
     *
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * Create a new SetActiveMenu instance.
     *
     * @param ControlPanelBuilder $builder
     */
    public function __construct(ControlPanelBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Request              $request
     * @param Authorizer           $authorizer
     * @param BreadcrumbCollection $breadcrumbs
     */
    public function handle(Request $request, Authorizer $authorizer, BreadcrumbCollection $breadcrumbs)
    {
        $controlPanel = $this->builder->getControlPanel();
        $menus        = $controlPanel->getMenu();

        /**
         * If we already have an active menu
         * then we don't need to do this.
         */
        if ($active = $menus->active()) {
            return;
        }

        foreach ($menus as $menu) {

            /**
             * Get the HREF for both the active
             * and loop iteration menu.
             */
            $href       = array_get($menu->getAttributes(), 'href');
            $activeHref = '';

            if ($active && $active instanceof MenuItemInterface) {
                $activeHref = array_get($active->getAttributes(), 'href');
            }

            /**
             * If the request URL does not even
             * contain the HREF then skip it.
             */
            if (!str_contains($request->url(), $href)) {
                continue;
            }

            /**
             * Compare the length of the active HREF
             * and loop iteration HREF. The longer the
             * HREF the more detailed and exact it is and
             * the more likely it is the active HREF and
             * therefore the active menu.
             */
            $hrefLength       = strlen($href);
            $activeHrefLength = strlen($activeHref);

            if ($hrefLength > $activeHrefLength) {
                $active = $menu;
            }
        }

        /**
         * If we have an active menu determined
         * then mark it as such.
         *
         * @var MenuItemInterface $active
         * @var MenuItemInterface $menu
         */
        if ($active) {
            if ($active->getParent()) {

                $active->setActive(true);

                $menu = $menus->get($active->getParent(), $menus->first());

                $menu->setHighlighted(true);

                $breadcrumbs->put($menu->getBreadcrumb() ?: $menu->getText(), $menu->getHref());
            } else {
                $active->setActive(true)->setHighlighted(true);
            }
        } elseif ($active = $menus->first()) {
            $active->setActive(true)->setHighlighted(true);
        }

        // No active menu!
        if (!$active) {
            return;
        }

        // Authorize the active menu.
        if (!$authorizer->authorize($active->getPermission())) {
            abort(403);
        }

        // Add the bread crumb.
        if (($breadcrumb = $active->getBreadcrumb()) !== false) {
            $breadcrumbs->put($breadcrumb ?: $active->getText(), $active->getHref());
        }
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command;

use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

/**
 * Class SetActiveSection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command
 */
class SetActiveSection implements SelfHandling
{

    /**
     * The control_panel builder.
     *
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * Create a new SetActiveSection instance.
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
        $sections     = $controlPanel->getSections();

        /**
         * If we already have an active section
         * then we don't need to do this.
         */
        if ($active = $sections->active()) {
            return;
        }

        foreach ($sections as $section) {

            /**
             * Get the HREF for both the active
             * and loop iteration section.
             */
            $href       = array_get($section->getAttributes(), 'href');
            $activeHref = '';

            if ($active && $active instanceof SectionInterface) {
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
             * therefore the active section.
             */
            $hrefLength       = strlen($href);
            $activeHrefLength = strlen($activeHref);

            if ($hrefLength > $activeHrefLength) {
                $active = $section;
            }
        }

        /**
         * If we have an active section determined
         * then mark it as such.
         */
        if ($active && $active instanceof SectionInterface) {
            $active->setActive(true);
        } elseif ($active = $sections->first()) {
            $active->setActive(true);
        }

        // No active section!
        if (!$active) {
            return;
        }

        // Authorize the active section.
        $authorizer->authorize($active->getPermission());

        // Add the bread crumb.
        if (($breadcrumb = $active->getBreadcrumb()) !== false) {
            $breadcrumbs->put($breadcrumb ?: $active->getText(), $active->getHref());
        }
    }
}

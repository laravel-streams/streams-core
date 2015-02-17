<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\Handler;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\SetActiveSection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;
use Illuminate\Http\Request;

/**
 * Class SetActiveSectionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\Handler
 */
class SetActiveSectionHandler
{

    /**
     * The HTTP request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new SetActiveSectionHandler instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the command.
     *
     * @param SetActiveSection $command
     */
    public function handle(SetActiveSection $command)
    {
        $builder      = $command->getBuilder();
        $controlPanel = $builder->getControlPanel();
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
            if (!str_contains($this->request->url(), $href)) {
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
        }
    }
}

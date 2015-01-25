<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\Handler;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\SetActiveSection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;

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
     * Handle the command.
     *
     * @param SetActiveSection $command
     */
    public function handle(SetActiveSection $command)
    {
        $builder  = $command->getBuilder();
        $controlPanel  = $builder->getControlPanel();
        $sections = $controlPanel->getSections();

        $section = $sections->first();

        if ($section instanceof SectionInterface) {
            $section->setActive(true);
        }
    }
}

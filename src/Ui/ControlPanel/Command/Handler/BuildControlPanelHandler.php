<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Command\Handler;

use Anomaly\Streams\Platform\Ui\ControlPanel\Command\BuildControlPanel;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Command\BuildButtons;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\BuildSections;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\SetActiveSection;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class BuildControlPanelHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Command\Handler
 */
class BuildControlPanelHandler
{

    use DispatchesCommands;

    /**
     * @param BuildControlPanel $command
     */
    public function handle(BuildControlPanel $command)
    {
        $builder = $command->getBuilder();

        $this->dispatch(new BuildSections($builder));
        $this->dispatch(new SetActiveSection($builder));

        $this->dispatch(new BuildButtons($builder));
    }
}

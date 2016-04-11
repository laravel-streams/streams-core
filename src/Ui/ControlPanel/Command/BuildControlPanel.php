<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Command;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Command\BuildButtons;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Command\BuildNavigation;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Command\SetActiveNavigationLink;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\BuildSections;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\SetActiveSection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class BuildControlPanel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Command
 */
class BuildControlPanel implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The builder object.
     *
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * Create a new BuildControlPanel instance.
     *
     * @param ControlPanelBuilder $builder
     */
    public function __construct(ControlPanelBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->dispatch(new BuildNavigation($this->builder));
        $this->dispatch(new SetActiveNavigationLink($this->builder));

        $this->dispatch(new BuildSections($this->builder));
        $this->dispatch(new SetActiveSection($this->builder));

        $this->dispatch(new BuildButtons($this->builder));
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Command;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Command\BuildButtons;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\BuildSections;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\SetActiveSection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesCommands;

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

    use DispatchesCommands;

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
        $this->dispatch(new BuildSections($this->builder));
        $this->dispatch(new SetActiveSection($this->builder));

        $this->dispatch(new BuildButtons($this->builder));
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Command;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\MenuBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class BuildMenu
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Command
 */
class BuildMenu implements SelfHandling
{

    /**
     * The control_panel builder.
     *
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * Create a new BuildMenu instance.
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
     * @param MenuBuilder $builder
     */
    public function handle(MenuBuilder $builder)
    {
        $builder->build($this->builder);
    }
}

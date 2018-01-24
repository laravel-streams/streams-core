<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Event;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

class GatherSections
{

    /**
     * The control panel builder.
     *
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * Create a new GatherSections instance.
     *
     * @param ControlPanelBuilder $builder
     */
    public function __construct(ControlPanelBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get the control panel builder.
     *
     * @return ControlPanelBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}

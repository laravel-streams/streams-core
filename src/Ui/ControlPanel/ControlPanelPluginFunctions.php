<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel;

/**
 * Class ControlPanelPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel
 */
class ControlPanelPluginFunctions
{

    /**
     * The control panel object.
     *
     * @var ControlPanel
     */
    protected $controlPanel = null;

    /**
     * The control panel builder.
     *
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * Create a new ControlPanelPluginFunctions instance.
     *
     * @param ControlPanelBuilder $builder
     */
    public function __construct(ControlPanelBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Return the control panel sections.
     *
     * @return Component\Section\SectionCollection
     */
    public function sections()
    {
        $this->build();

        return $this->controlPanel->getSections();
    }

    /**
     * Return the buttons for the active section.
     *
     * @return \Illuminate\Support\Collection
     */
    public function buttons()
    {
        $this->build();

        return $this->controlPanel->getButtons();
    }

    /**
     * Build the control panel. We defer this to the methods
     * because the injection causes a miss in the modules->active()
     * portion of the build process.
     */
    protected function build()
    {
        if (!$this->controlPanel) {
            $this->controlPanel = $this->builder->build();
        }
    }
}

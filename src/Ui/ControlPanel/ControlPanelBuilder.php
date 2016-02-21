<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel;

use Anomaly\Streams\Platform\Ui\ControlPanel\Command\BuildControlPanel;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ControlPanelBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel
 */
class ControlPanelBuilder
{

    use DispatchesJobs;

    /**
     * The module menu.
     *
     * @var array
     */
    protected $menu = [];

    /**
     * The section buttons.
     *
     * @var array
     */
    protected $buttons = [];

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * The control_panel object.
     *
     * @var ControlPanel
     */
    protected $controlPanel;

    /**
     * Create a new ControlPanelBuilder instance.
     *
     * @param ControlPanel $controlPanel
     */
    public function __construct(ControlPanel $controlPanel)
    {
        $this->controlPanel = $controlPanel;
    }

    /**
     * Build the control_panel.
     */
    public function build()
    {
        $this->dispatch(new BuildControlPanel($this));

        return $this->controlPanel;
    }

    /**
     * Get the control_panel.
     *
     * @return ControlPanel
     */
    public function getControlPanel()
    {
        return $this->controlPanel;
    }

    /**
     * Get the section buttons.
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the section buttons.
     *
     * @param array $buttons
     */
    public function setButtons($buttons)
    {
        $this->buttons = $buttons;
    }

    /**
     * Get the module sections.
     *
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Set the sections.
     *
     * @param array $sections
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
    }

    /**
     * Get the module menu.
     *
     * @return array
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set the menu.
     *
     * @param array $menu
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
    }

    /**
     * Return the active control panel section.
     *
     * @return Component\Section\Contract\SectionInterface|null
     */
    public function getActiveSection()
    {
        $sections = $this->getControlPanelSections();

        return $sections->active();
    }

    /**
     * Get the control panel sections.
     *
     * @return Component\Section\SectionCollection
     */
    public function getControlPanelSections()
    {
        return $this->controlPanel->getSections();
    }
}

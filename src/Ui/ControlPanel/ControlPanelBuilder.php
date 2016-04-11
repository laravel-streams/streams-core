<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel;

use Anomaly\Streams\Platform\Ui\ControlPanel\Command\BuildControlPanel;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\ButtonHandler;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationHandler;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionHandler;
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
     * The section buttons.
     *
     * @var array
     */
    protected $buttons = ButtonHandler::class;

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = SectionHandler::class;

    /**
     * The navigation links.
     *
     * @var array
     */
    protected $navigation = NavigationHandler::class;

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
     * Get the module navigation.
     *
     * @return array
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     * Set the navigation.
     *
     * @param array $navigation
     */
    public function setNavigation($navigation)
    {
        $this->navigation = $navigation;
    }

    /**
     * Return the active control panel section.
     *
     * @return Component\Section\Contract\SectionInterface|null
     */
    public function getControlPanelActiveSection()
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

    /**
     * Get the control panel navigation.
     *
     * @return Component\Navigation\NavigationCollection
     */
    public function getControlPanelNavigation()
    {
        return $this->controlPanel->getNavigation();
    }
}

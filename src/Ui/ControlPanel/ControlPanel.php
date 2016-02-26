<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Contract\MenuItemInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\MenuCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Illuminate\Support\Collection;

/**
 * Class ControlPanel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel
 */
class ControlPanel
{

    /**
     * The menu collection.
     *
     * @var MenuCollection
     */
    protected $menu;

    /**
     * The section buttons.
     *
     * @var Collection
     */
    protected $buttons;

    /**
     * The section collection.
     *
     * @var SectionCollection
     */
    protected $sections;

    /**
     * Create a new ControlPanel instance.
     *
     * @param Collection        $buttons
     * @param SectionCollection $sections
     * @param MenuCollection    $menu
     */
    function __construct(Collection $buttons, SectionCollection $sections, MenuCollection $menu)
    {
        $this->menu     = $menu;
        $this->buttons  = $buttons;
        $this->sections = $sections;
    }

    /**
     * Add a button to the button collection.
     *
     * @param ButtonInterface $button
     * @return $this
     */
    public function addButton(ButtonInterface $button)
    {
        $this->buttons->push($button);

        return $this;
    }

    /**
     * Get the section buttons.
     *
     * @return Collection
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Add a section to the section collection.
     *
     * @param SectionInterface $section
     * @return $this
     */
    public function addSection(SectionInterface $section)
    {
        $this->sections->push($section);

        return $this;
    }

    /**
     * Get the module sections.
     *
     * @return SectionCollection
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Add a menu item.
     *
     * @param MenuItemInterface $menuItem
     * @return $this
     */
    public function addMenuItem(MenuItemInterface $menuItem)
    {
        $this->menu->push($menuItem);

        return $this;
    }

    /**
     * Get the menu.
     *
     * @return MenuCollection
     */
    public function getMenu()
    {
        return $this->menu;
    }
}

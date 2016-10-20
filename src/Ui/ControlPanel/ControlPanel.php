<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Contract\NavigationLinkInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Illuminate\Support\Collection;

/**
 * Class ControlPanel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ControlPanel
{

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
     * The navigation collection.
     *
     * @var NavigationCollection
     */
    protected $navigation;

    /**
     * Create a new ControlPanel instance.
     *
     * @param Collection           $buttons
     * @param SectionCollection    $sections
     * @param NavigationCollection $navigation
     */
    public function __construct(Collection $buttons, SectionCollection $sections, NavigationCollection $navigation)
    {
        $this->buttons    = $buttons;
        $this->sections   = $sections;
        $this->navigation = $navigation;
    }

    /**
     * Add a button to the button collection.
     *
     * @param  ButtonInterface $button
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
     * @param  SectionInterface $section
     * @return $this
     */
    public function addSection(SectionInterface $section)
    {
        $this->sections->put($section->getSlug(), $section);

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
     * Get the active section.
     *
     * @return SectionInterface|null
     */
    public function getActiveSection()
    {
        return $this->sections->active();
    }

    /**
     * Add a navigation link.
     *
     * @param  NavigationLinkInterface $link
     * @return $this
     */
    public function addNavigationLink(NavigationLinkInterface $link)
    {
        $this->navigation->push($link);

        return $this;
    }

    /**
     * Get the navigation.
     *
     * @return NavigationCollection
     */
    public function getNavigation()
    {
        return $this->navigation;
    }
}

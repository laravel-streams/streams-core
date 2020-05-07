<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Section;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\Shortcut;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationLink;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\ShortcutCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationCollection;

/**
 * Class ControlPanel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ControlPanel implements Arrayable, Jsonable
{

    /**
     * The section buttons.
     *
     * @var ButtonCollection
     */
    public $buttons;

    /**
     * The section collection.
     *
     * @var SectionCollection
     */
    public $sections;

    /**
     * The shortcut collection.
     *
     * @var ShortcutCollection
     */
    public $shortcuts;

    /**
     * The navigation collection.
     *
     * @var NavigationCollection
     */
    public $navigation;

    /**
     * Create a new ControlPanel instance.
     *
     * @param ButtonCollection $buttons
     * @param SectionCollection $sections
     * @param ShortcutCollection $shortcuts
     * @param NavigationCollection $navigation
     */
    public function __construct(
        ButtonCollection $buttons,
        SectionCollection $sections,
        ShortcutCollection $shortcuts,
        NavigationCollection $navigation
    ) {
        $this->buttons    = $buttons;
        $this->sections   = $sections;
        $this->shortcuts  = $shortcuts;
        $this->navigation = $navigation;
    }

    /**
     * Add a button to the button collection.
     *
     * @param  Button$button
     * @return $this
     */
    public function addButton(Button $button)
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
     * @param  Section $section
     * @return $this
     */
    public function addSection(Section $section)
    {
        $this->sections->put($section->slug, $section);

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
     * Add a shortcut to the shortcut collection.
     *
     * @param  Shortcut $shortcut
     * @return $this
     */
    public function addShortcut(Shortcut $shortcut)
    {
        $this->shortcuts->put($shortcut->slug, $shortcut);

        return $this;
    }

    /**
     * Get the module shortcuts.
     *
     * @return ShortcutCollection
     */
    public function getShortcuts()
    {
        return $this->shortcuts;
    }

    /**
     * Add a navigation link.
     *
     * @param  NavigationLink $link
     * @return $this
     */
    public function addNavigationLink(NavigationLink $link)
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

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Hydrator::dehydrate($this);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}

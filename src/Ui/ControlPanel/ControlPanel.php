<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Illuminate\Support\Collection;

/**
 * Class ControlPanel.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel
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
     * The theme sections.
     *
     * @var SectionCollection
     */
    protected $sections;

    /**
     * Create a new ControlPanel instance.
     *
     * @param Collection        $buttons
     * @param SectionCollection $sections
     */
    public function __construct(Collection $buttons, SectionCollection $sections)
    {
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
}

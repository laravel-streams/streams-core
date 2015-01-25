<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel;

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
     * The section buttons.
     *
     * @var Collection
     */
    protected $buttons;

    /**
     * The module sections.
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
    function __construct(Collection $buttons, SectionCollection $sections)
    {
        $this->buttons  = $buttons;
        $this->sections = $sections;
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
     * Get the module sections.
     *
     * @return SectionCollection
     */
    public function getSections()
    {
        return $this->sections;
    }
}

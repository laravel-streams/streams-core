<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Type;

use Anomaly\Streams\Platform\Ui\Form\Section\Contract\TabbedSectionInterface;
use Anomaly\Streams\Platform\Ui\Form\Tab\TabCollection;

/**
 * Class TabbedSection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Section\Type
 */
class TabbedSection implements TabbedSectionInterface
{

    /**
     * The section tabs.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Tab\TabCollection
     */
    protected $tabs;

    /**
     * Create a new TabbedSection intance.
     *
     * @param TabCollection $tabs
     */
    public function __construct(TabCollection $tabs)
    {
        $this->tabs = $tabs;
    }

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return array
     */
    public function viewData(array $arguments = [])
    {
        $html = 'Tabbed Section';

        return compact('html');
    }

    /**
     * Set the tabs.
     *
     * @param  $tabs
     * @return $this
     */
    public function setTabs($tabs)
    {
        $this->tabs = $tabs;

        return $this;
    }

    /**
     * Get the tabs.
     *
     * @return TabCollection
     */
    public function getTabs()
    {
        return $this->tabs;
    }
}

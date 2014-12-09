<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Type;

use Anomaly\Streams\Platform\Ui\Form\Section\Contract\TabbedSectionInterface;
use Anomaly\Streams\Platform\Ui\Form\Tab\TabCollection;

class TabbedSection implements TabbedSectionInterface
{

    protected $tabs;

    function __construct(TabCollection $tabs)
    {
        $this->tabs = $tabs;
    }

    public function viewData(array $arguments = [])
    {
        $html = 'Tabbed Section';

        return compact('html');
    }

    public function setTabs($tabs)
    {
        $this->tabs = $tabs;

        return $this;
    }

    public function getTabs()
    {
        return $this->tabs;
    }
}
 
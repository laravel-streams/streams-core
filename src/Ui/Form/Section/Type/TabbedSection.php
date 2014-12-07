<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Type;

use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;
use Anomaly\Streams\Platform\Ui\Form\Tab\TabCollection;

class TabbedSection implements SectionInterface
{

    protected $tabs;

    function __construct(TabCollection $tabs)
    {
        $this->tabs = $tabs;
    }

    public function viewData()
    {
        $html = 'Tabbed Section';

        return compact('html');
    }
}
 
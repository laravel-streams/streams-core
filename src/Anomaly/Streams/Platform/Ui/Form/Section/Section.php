<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Layout\Contract\LayoutInterface;
use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;

class Section implements SectionInterface
{

    protected $layout;

    function __construct(LayoutInterface $layout)
    {
        $this->layout = $layout;
    }

    public function viewData()
    {
        $html = 'TEST';

        return compact('html');
    }
}
 
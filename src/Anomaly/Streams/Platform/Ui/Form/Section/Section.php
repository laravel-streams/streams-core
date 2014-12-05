<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Layout\Contract\LayoutInterface;
use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;

class Section implements SectionInterface
{

    protected $view = 'ui/form/sections/default/index';

    protected $layout;

    function __construct(LayoutInterface $layout, $view = null)
    {
        $this->layout = $layout;

        if ($view) {

            $this->view = $view;
        }
    }

    public function viewData()
    {
        $layout = $this->layout->viewData();

        $html = view($this->view, compact('layout'));

        return compact('html');
    }
}
 
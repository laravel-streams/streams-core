<?php namespace Anomaly\Streams\Platform\Ui\Form\Layout;

use Anomaly\Streams\Platform\Ui\Form\Layout\Contract\LayoutInterface;

class Layout implements LayoutInterface
{

    public function viewData()
    {
        return ['html' => 'Boom!'];
    }
}
 
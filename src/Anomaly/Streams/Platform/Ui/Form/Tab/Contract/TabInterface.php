<?php namespace Anomaly\Streams\Platform\Ui\Form\Tab\Contract;

use Anomaly\Streams\Platform\Ui\Form\Layout\Contract\LayoutInterface;

interface TabInterface
{

    public function viewData();

    public function setLayout(LayoutInterface $layout);

    public function getLayout();

    public function setText($text);

    public function getText();
}
 
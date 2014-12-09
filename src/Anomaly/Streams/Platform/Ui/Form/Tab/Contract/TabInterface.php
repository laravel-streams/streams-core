<?php namespace Anomaly\Streams\Platform\Ui\Form\Tab\Contract;

interface TabInterface
{

    public function viewData(array $arguments = []);

    public function setText($text);

    public function getText();
}
 
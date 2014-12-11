<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Contract;

interface TabbedSectionInterface
{
    public function viewData(array $arguments = []);

    public function setTabs($tabs);

    public function getTabs();
}

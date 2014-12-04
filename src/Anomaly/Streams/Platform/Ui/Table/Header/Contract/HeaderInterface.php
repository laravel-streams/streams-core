<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Contract;

interface HeaderInterface
{

    public function viewData();

    public function setPrefix($prefix);

    public function getPrefix();

    public function setText($text);

    public function getText();
}
 
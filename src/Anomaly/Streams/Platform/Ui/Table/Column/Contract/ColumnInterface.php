<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Contract;

use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;

interface ColumnInterface
{

    public function viewData();

    public function setHeader(HeaderInterface $header);

    public function getHeader();

    public function setPrefix($prefix);

    public function getPrefix();

    public function setClass($class);

    public function getClass();

    public function setValue($value);

    public function getValue();
}
 
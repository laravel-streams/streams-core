<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Contract;

interface InputFilterInterface extends FilterInterface
{

    public function setType($type);

    public function getType();
}
 
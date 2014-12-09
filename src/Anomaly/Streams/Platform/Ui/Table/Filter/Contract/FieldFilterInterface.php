<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Contract;

interface FieldFilterInterface extends FilterInterface
{

    public function setField($field);

    public function getField();

    public function getStream();
}
 
<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Contract;

interface ColumnInterface
{

    public function setPrefix($prefix);

    public function getPrefix();

    public function setClass($class);

    public function getClass();

    public function setField($field);

    public function getField();

    public function setValue($value);

    public function getValue();
}
 
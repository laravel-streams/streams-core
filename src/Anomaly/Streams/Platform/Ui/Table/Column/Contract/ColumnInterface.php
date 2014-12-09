<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Contract;

interface ColumnInterface
{

    public function viewData(array $arguments = []);

    public function setHeader($header);

    public function getHeader();

    public function setPrefix($prefix);

    public function getPrefix();

    public function setStream($stream);

    public function getStream();

    public function setClass($class);

    public function getClass();

    public function setEntry($entry);

    public function getEntry();

    public function setValue($value);

    public function getValue();
}
 
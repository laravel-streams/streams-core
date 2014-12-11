<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Contract;

interface SelectFilterInterface extends FilterInterface
{
    public function setOptions(array $options);

    public function getOptions();
}

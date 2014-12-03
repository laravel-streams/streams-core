<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

class ParseFilterInputCommand
{

    protected $filters;

    function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function getFilters()
    {
        return $this->filters;
    }
}
 
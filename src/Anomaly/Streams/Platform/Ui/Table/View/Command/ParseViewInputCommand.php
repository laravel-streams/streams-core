<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

class ParseViewInputCommand
{

    protected $views;

    function __construct(array $views)
    {
        $this->views = $views;
    }

    public function getViews()
    {
        return $this->views;
    }
}
 
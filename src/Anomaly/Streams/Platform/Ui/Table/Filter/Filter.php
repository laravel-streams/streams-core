<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

class Filter implements FilterInterface
{

    protected $slug;

    protected $prefix;

    protected $handler;

    function __construct($slug, $prefix = null, $handler = null)
    {
        $this->slug    = $slug;
        $this->prefix  = $prefix;
        $this->handler = $handler;
    }

    public function handle(Table $table)
    {
        //
    }

    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }
}
 
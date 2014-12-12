<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

class Filter implements FilterInterface
{
    protected $slug;

    protected $prefix;

    protected $active;

    protected $handler;

    protected $placeholder;

    public function __construct($slug, $prefix = null, $active = false, $handler = null, $placeholder = null)
    {
        $this->slug        = $slug;
        $this->prefix      = $prefix;
        $this->active      = $active;
        $this->handler     = $handler;
        $this->placeholder = $placeholder;
    }

    public function handle(Table $table, Builder $query)
    {
        $query = $query->where($this->getSlug(), 'LIKE', "%{$this->getValue()}%");
    }

    public function viewData(array $arguments = [])
    {
        $input = $this->getInput();

        return compact('input');
    }

    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    public function isActive()
    {
        return $this->active;
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

    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
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

    protected function getName()
    {
        return $this->getPrefix() . $this->getSlug();
    }

    protected function getValue()
    {
        return app('request')->get($this->getName());
    }

    protected function getInput()
    {
        return null;
    }
}

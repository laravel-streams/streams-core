<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;
use Illuminate\Database\Eloquent\Builder;

class View implements ViewInterface
{
    protected $text;

    protected $slug;

    protected $active;

    protected $prefix;

    protected $handler;

    protected $attributes;

    public function __construct($text, $slug, $active = false, $prefix = null, $handler = null, array $attributes = [])
    {
        $this->text       = $text;
        $this->slug       = $slug;
        $this->active     = $active;
        $this->prefix     = $prefix;
        $this->handler    = $handler;
        $this->attributes = $attributes;
    }

    public function handle(Table $table, Builder $query)
    {
        // No modification by default
    }

    public function viewData(array $arguments = [])
    {
        $url        = $this->getUrl();
        $active     = $this->isActive();
        $text       = trans($this->getText());
        $attributes = app('html')->attributes($this->getAttributes());

        return compact('active', 'text', 'url', 'attributes');
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setActive($active)
    {
        $this->active = ($active);

        return $this;
    }

    public function isActive()
    {
        return ($this->active);
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

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function getText()
    {
        return $this->text;
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

    protected function getUrl()
    {
        return url(app('request')->path() . '?' . $this->getPrefix() . 'view=' . $this->getSlug());
    }
}

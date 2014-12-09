<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

class Action implements ActionInterface
{

    protected $text;

    protected $slug;

    protected $icon;

    protected $prefix;

    protected $active;

    protected $handler;

    protected $attributes;

    function __construct(
        $text,
        $slug,
        $icon = null,
        $prefix = null,
        $active = false,
        $handler = null,
        array $attributes = []
    ) {
        $this->text       = $text;
        $this->slug       = $slug;
        $this->icon       = $icon;
        $this->prefix     = $prefix;
        $this->active     = $active;
        $this->handler    = $handler;
        $this->attributes = $attributes;
    }

    public function viewData(array $arguments = [])
    {
        $text = $this->getText();
        $slug = $this->getSlug();

        $text = trans($text);

        return evaluate(compact('text', 'slug'), $arguments);
    }

    public function handle(Table $table, array $ids)
    {
        //
    }

    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
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

    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
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

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }
}
 
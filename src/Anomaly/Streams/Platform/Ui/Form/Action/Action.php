<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

use Anomaly\Streams\Platform\Ui\Form\Form;

class Action
{

    protected $text;

    protected $slug;

    protected $prefix;

    protected $active;

    protected $handler;

    protected $attributes;

    function __construct(
        $text,
        $slug,
        $prefix = null,
        $active = false,
        $handler = null,
        array $attributes = []
    ) {
        $this->text       = $text;
        $this->slug       = $slug;
        $this->prefix     = $prefix;
        $this->active     = $active;
        $this->handler    = $handler;
        $this->attributes = $attributes;
    }

    public function handle(Form $form)
    {
        //
    }

    public function viewData()
    {
        $text = trans($this->getText());
        $slug = $this->getSlug();

        return compact('text', 'slug');
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

    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    public function getHandler()
    {
        return $this->handler;
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
}
 
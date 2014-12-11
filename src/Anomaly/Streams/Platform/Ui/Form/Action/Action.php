<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Form\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

class Action extends Button implements ActionInterface
{
    protected $slug;

    protected $prefix;

    protected $active;

    protected $handler;

    public function __construct(
        $slug,
        $text = null,
        $icon = null,
        $class = null,
        $prefix = null,
        $active = false,
        $handler = null,
        $type = 'default',
        array $attributes = []
    ) {
        $this->slug    = $slug;
        $this->prefix  = $prefix;
        $this->active  = $active;
        $this->handler = $handler;

        parent::__construct($type, $text, $class, $icon, $attributes);
    }

    public function handle(Form $form)
    {
        //
    }

    public function viewData(array $arguments = [])
    {
        $data = parent::viewData();

        $value = $this->getSlug();

        return evaluate($data + compact('value'), $arguments);
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

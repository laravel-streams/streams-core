<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Form\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

class Action implements ActionInterface
{

    protected $slug;

    protected $prefix;

    protected $active;

    protected $button;

    protected $handler;

    protected $attributes;

    function __construct(
        $slug,
        $prefix = null,
        $active = false,
        $handler = null,
        array $attributes = [],
        ButtonInterface $button = null
    ) {
        $this->slug       = $slug;
        $this->prefix     = $prefix;
        $this->button     = $button;
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
        $button = null;

        if ($this->button) {

            $button = $this->button->viewData();
        }

        $value = $this->getSlug();

        return compact('button', 'value');
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
 
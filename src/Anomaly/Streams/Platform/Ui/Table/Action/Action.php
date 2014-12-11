<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;

class Action extends Button implements ActionInterface
{

    protected $slug;

    protected $active;

    protected $prefix;

    function __construct(
        $slug,
        $icon = null,
        $text = null,
        $class = null,
        $prefix = null,
        $active = false,
        $type = 'default',
        array $attributes = []
    ) {
        parent::__construct($type, $text, $class, $icon, $attributes);

        $this->slug   = $slug;
        $this->active = $active;
        $this->prefix = $prefix;

        $this->putAttribute('type', 'submit');
        $this->putAttribute('name', 'action');
    }


    public function viewData(array $arguments = [])
    {
        $data = parent::viewData($arguments);

        $data['slug'] = $this->getSlug();

        return $data;
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
 
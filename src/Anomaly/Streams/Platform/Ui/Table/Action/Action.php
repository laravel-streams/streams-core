<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Icon\Contract\IconInterface;
use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

class Action implements ActionInterface
{

    protected $text;

    protected $slug;

    protected $icon;

    protected $prefix;

    protected $handler;

    function __construct($text, $slug, $icon = false, $prefix = null, $handler = null)
    {
        $this->text    = $text;
        $this->slug    = $slug;
        $this->icon    = $icon;
        $this->prefix  = $prefix;
        $this->handler = $handler;
    }

    public function handle(Table $table, array $ids)
    {
        //
    }

    public function setIcon(IconInterface $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
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
}
 
<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;

class Section implements SectionInterface
{
    protected $title;

    protected $body;

    protected $view;

    public function __construct($title = null, $body = null, $view = 'ui/form/sections/default/index')
    {
        $this->body  = $body;
        $this->view  = $view;
        $this->title = $title;
    }

    public function viewData(array $arguments = [])
    {
        $title = trans($this->getTitle());

        $body = $this->getBody();

        $html = view($this->getView(), compact('title', 'body'));

        return compact('html');
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    public function getView()
    {
        return $this->view;
    }
}

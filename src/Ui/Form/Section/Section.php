<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;

class Section implements SectionInterface
{

    protected $title;

    protected $body;

    function __construct($title = null, $body = null)
    {
        $this->body  = $body;
        $this->title = $title;
    }

    public function viewData()
    {
        $title = trans($this->getTitle());

        $body = $this->getBody();

        $html = view('ui/form/sections/default/index', compact('title', 'body'));

        return compact('html');
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

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }
}
 
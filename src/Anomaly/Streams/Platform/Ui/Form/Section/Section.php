<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;

class Section implements SectionInterface
{

    protected $title;

    protected $body;

    protected $view;

    function __construct($title = null, $body = null, $view = 'ui/form/sections/default/index')
    {
        $this->body  = $body;
        $this->view  = $view;
        $this->title = $title;
    }

    public function viewData()
    {
        $title = trans($this->title);

        $body = $this->body;

        $html = view($this->view, compact('title', 'body'));

        return compact('html');
    }
}
 
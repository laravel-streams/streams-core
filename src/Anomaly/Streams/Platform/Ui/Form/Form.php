<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Form\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Form\Section\SectionCollection;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

class Form
{

    use EventGenerator;
    use DispatchableTrait;

    protected $prefix = 'form_';

    protected $view = 'ui/form/index';

    protected $wrapper = 'wrappers/blank';

    protected $data = [];

    protected $stream = null;

    protected $content = null;

    protected $response = null;

    protected $sections;

    protected $actions;

    protected $buttons;

    function __construct(SectionCollection $sections, ActionCollection $actions, ButtonCollection $buttons)
    {
        $this->actions  = $actions;
        $this->buttons  = $buttons;
        $this->sections = $sections;
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

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function putData($key, $data)
    {
        $this->data[$key] = $data;

        return $this;
    }

    public function pullData($key, $default = null)
    {
        return array_get($this->data, $key, $default);
    }

    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    public function getStream()
    {
        return $this->stream;
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

    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    public function getWrapper()
    {
        return $this->wrapper;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function getButtons()
    {
        return $this->buttons;
    }

    public function getSections()
    {
        return $this->sections;
    }
}
 
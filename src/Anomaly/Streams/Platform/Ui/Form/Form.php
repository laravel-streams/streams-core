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

    protected $include = [];

    protected $skips = [];

    protected $view = 'ui/form/index';

    protected $wrapper = 'wrappers/blank';

    protected $rules = [];

    protected $input = [];

    protected $data = [];

    protected $stream = null;

    protected $content = null;

    protected $response = null;

    protected $entry = null;

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

    public function setInclude($include)
    {
        $this->include = $include;

        return $this;
    }

    public function getInclude()
    {
        return $this->include;
    }

    public function addInclude($include)
    {
        $this->include[] = $include;

        return $this;
    }

    public function setSkips($skips)
    {
        $this->skips = $skips;

        return $this;
    }

    public function getSkips()
    {
        return $this->skips;
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

    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function putRules($key, $rules)
    {
        $this->rules[$key] = $rules;

        return $this;
    }

    public function pullRules($key, $default = null)
    {
        return array_get($this->rules, $key, $default);
    }

    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function putInput($key, $input)
    {
        $this->input[$key] = $input;

        return $this;
    }

    public function pullInput($key, $default = null)
    {
        return array_get($this->input, $key, $default);
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

    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    public function getEntry()
    {
        return $this->entry;
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
 
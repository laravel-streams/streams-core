<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Form\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Form\Section\SectionCollection;
use Illuminate\Http\Response;

/**
 * Class Form
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class Form
{

    /**
     * The form prefix.
     *
     * @var string
     */
    protected $prefix = 'form_';

    /**
     * Included field slugs.
     *
     * @var array
     */
    protected $include = [];

    /**
     * Skipped field slugs.
     *
     * @var array
     */
    protected $skips = [];

    /**
     * The form view.
     *
     * @var string
     */
    protected $view = 'streams::ui/form/index';

    /**
     * The form wrapper for rendering.
     *
     * @var string
     */
    protected $wrapper = 'streams::wrappers/blank';

    /**
     * The form rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The form input.
     *
     * @var array
     */
    protected $input = [];

    /**
     * The form view data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * The form stream object.
     *
     * @var null
     */
    protected $stream = null;

    /**
     * The form content.
     *
     * @var null
     */
    protected $content = null;

    /**
     * The form response.
     *
     * @var null
     */
    protected $response = null;

    /**
     * The form entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * The sections collection.
     *
     * @var Section\SectionCollection
     */
    protected $sections;

    /**
     * The actions collection.
     *
     * @var Action\ActionCollection
     */
    protected $actions;

    /**
     * The buttons collection.
     *
     * @var \Anomaly\Streams\Platform\Ui\Button\ButtonCollection
     */
    protected $buttons;

    /**
     * Create a new Form instance.
     *
     * @param SectionCollection $sections
     * @param ActionCollection  $actions
     * @param ButtonCollection  $buttons
     */
    public function __construct(SectionCollection $sections, ActionCollection $actions, ButtonCollection $buttons)
    {
        $this->actions  = $actions;
        $this->buttons  = $buttons;
        $this->sections = $sections;
    }

    /**
     * Set the form prefix.
     *
     * @param $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the form prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set included fields.
     *
     * @param $include
     * @return $this
     */
    public function setInclude($include)
    {
        $this->include = $include;

        return $this;
    }

    /**
     * Get included fields.
     *
     * @return array
     */
    public function getInclude()
    {
        return $this->include;
    }

    /**
     * Add an included field.
     *
     * @param $include
     * @return $this
     */
    public function addInclude($include)
    {
        $this->include[] = $include;

        return $this;
    }

    /**
     * Set skipped fields.
     *
     * @param $skips
     * @return $this
     */
    public function setSkips($skips)
    {
        $this->skips = $skips;

        return $this;
    }

    /**
     * Get skipped fields.
     *
     * @return array
     */
    public function getSkips()
    {
        return $this->skips;
    }

    /**
     * Set the form content.
     *
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the form content.
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the form rules.
     *
     * @param $rules
     * @return $this
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get the form rules.
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Put a rule.
     *
     * @param $key
     * @param $rules
     * @return $this
     */
    public function putRules($key, $rules)
    {
        $this->rules[$key] = $rules;

        return $this;
    }

    /**
     * Pull a rule.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function pullRules($key, $default = null)
    {
        return array_get($this->rules, $key, $default);
    }

    /**
     * Set the input.
     *
     * @param $input
     * @return $this
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get the input.
     *
     * @return array
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Put input.
     *
     * @param $key
     * @param $input
     * @return $this
     */
    public function putInput($key, $input)
    {
        $this->input[$key] = $input;

        return $this;
    }

    /**
     * Pull input.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function pullInput($key, $default = null)
    {
        return array_get($this->input, $key, $default);
    }

    /**
     * Set the form data.
     *
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the form data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Put data.
     *
     * @param $key
     * @param $data
     * @return $this
     */
    public function putData($key, $data)
    {
        $this->data[$key] = $data;

        return $this;
    }

    /**
     * Pull data.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function pullData($key, $default = null)
    {
        return array_get($this->data, $key, $default);
    }

    /**
     * Set the form response.
     *
     * @param $response
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get the form response.
     *
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the entry.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get the entry.
     *
     * @return Response|null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the stream.
     *
     * @param $stream
     * @return $this
     */
    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Get the stream.
     *
     * @return StreamInterface|null
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the view.
     *
     * @param $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the view.
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set the wrapper.
     *
     * @param $wrapper
     * @return $this
     */
    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    /**
     * Get the wrapper.
     *
     * @return string
     */
    public function getWrapper()
    {
        return $this->wrapper;
    }

    /**
     * Get the actions.
     *
     * @return ActionCollection
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Get the buttons.
     *
     * @return ButtonCollection
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Get the sections.
     *
     * @return SectionCollection
     */
    public function getSections()
    {
        return $this->sections;
    }
}

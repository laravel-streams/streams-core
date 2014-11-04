<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Traits\CallableTrait;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;
use Anomaly\Streams\Platform\Traits\EventableTrait;
use Anomaly\Streams\Platform\Traits\TransformableTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Ui
 *
 * The base UI class.
 * All other UI classes extend this one.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class Ui
{

    use CallableTrait;
    use EventableTrait;
    use CommandableTrait;
    use DispatchableTrait;
    use TransformableTrait;

    protected $response;

    /**
     * The UI prefix. This helps us
     * distinguish logic for multiple
     * instances of a UI.
     *
     * @var string
     */
    protected $prefix = 'ui';

    /**
     * The rendering wrapper view.
     *
     * @var string
     */
    protected $wrapper = 'html/blank';

    /**
     * The page title.
     *
     * @var string
     */
    protected $title = 'misc.untitled'; // TODO: Could pry do better than this default.

    /**
     * The working model object if any.
     *
     * @var
     */
    protected $model = null;

    /**
     * Create a new Ui instance.
     */
    public function __construct()
    {
        $this->boot();
    }

    /**
     * Setup the class.
     */
    protected function boot()
    {
    }

    /**
     * Trigger the response.
     */
    protected function trigger()
    {
        return null;
    }

    /**
     * Get the response.
     *
     * @return \Illuminate\View\View
     */
    public function make()
    {
        $content = $this->trigger();

        $title = trans(evaluate($this->title, [$this]));

        if ($response = $this->fire('response') and $response instanceof Response) {

            return $response;
        }

        return view($this->wrapper, compact('content', 'title'));
    }

    public function render()
    {
        return $this->fire('make');
    }

    /**
     * @param mixed $response
     * return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Set the UI prefix.
     *
     * @param string $prefix
     * return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the UI prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        if ($this->prefix) {

            return $this->prefix . (ends_with($this->prefix, '_') ? : '_');
        }

        return $this->prefix;
    }

    /**
     * Set the model object.
     *
     * @param EntryInterface $model
     * @return $this
     */
    public function setModel(EntryInterface $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the model object.
     *
     * @return null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the title.
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the view wrapper.
     *
     * @param $wrapper
     * @return $this
     */
    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    protected function onMake()
    {
        return $this->make();
    }
}

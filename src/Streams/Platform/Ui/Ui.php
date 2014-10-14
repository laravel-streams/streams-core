<?php namespace Streams\Platform\Ui;

use Streams\Platform\Traits\CallableTrait;
use Streams\Platform\Traits\EventableTrait;
use Streams\Platform\Traits\DispatchableTrait;

class Ui
{
    use CallableTrait;
    use EventableTrait;
    use DispatchableTrait;

    /**
     * @var null
     */
    protected $output = null;

    /**
     * @var string
     */
    protected $wrapper = 'html/blank';

    /**
     * @var string
     */
    protected $title = 'misc.untitled';

    /**
     * @var
     */
    protected $model;

    /**
     * @param null $model
     */
    function __construct($model = null)
    {
        $this->model = $model;
    }

    /**
     * Do the rendering logic in extending classes.
     */
    protected function trigger()
    {
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $content = $this->getOutput();

        $title = trans(evaluate($this->title, [$this]));

        return view($this->wrapper, compact('content', 'title'));
    }

    /**
     * @param $listener
     * return $this
     */
    public function addListener($listener)
    {
        app('events')->listen('Streams.Platform.Ui.Table.*', $listener);

        return $this;
    }

    /**
     * @return null
     */
    public function getOutput()
    {
        $this->trigger();

        return $this->output;
    }

    /**
     * @param mixed $model
     * return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param $wrapper
     * @return $this
     */
    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }
}

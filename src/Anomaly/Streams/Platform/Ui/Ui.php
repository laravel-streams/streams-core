<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Traits\CallableTrait;
use Anomaly\Streams\Platform\Traits\EventableTrait;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

class Ui
{
    use CallableTrait;
    use EventableTrait;
    use DispatchableTrait;

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
    protected $model = null;

    public function __construct()
    {
        $this->boot();
    }

    /**
     * Setup the class.
     */
    protected function boot()
    {
        //
    }

    /**
     * Build the content.
     */
    protected function build()
    {
        return null;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function make()
    {
        $content = $this->build();

        $title = trans(evaluate($this->title, [$this]));

        return view($this->wrapper, compact('content', 'title'));
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

    public function getTitle()
    {
        return $this->title;
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

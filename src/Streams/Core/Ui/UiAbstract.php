<?php namespace Streams\Platform\Ui;

use Streams\Platform\Traits\CallableTrait;
use Streams\Platform\Ui\Support\Repository;
use Streams\Platform\Ui\Contract\UiInterface;

abstract class UiAbstract implements UiInterface
{
    use CallableTrait;

    /**
     * The output of the UI.
     *
     * @var null
     */
    protected $output = null;

    /**
     * The model we are working with.
     *
     * @var null
     */
    protected $model = null;

    /**
     * The title of the page / panel.
     *
     * @var null
     */
    protected $title = 'misc.untitled';

    /**
     * The wrapper view.
     *
     * @var null
     */
    protected $wrapper = null;

    /**
     * Trigger rendering.
     *
     * @return null
     */
    protected function trigger()
    {
        return null;
    }

    /**
     * Return the compiled the view output.
     *
     * @param bool $return
     * @return mixed
     */
    public function render()
    {
        $content = $this->output();

        $title  = trans(evaluate($this->title, [$this]));

        return \View::make($this->wrapper, compact('content', 'title'));
    }

    /**
     * Return the output.
     *
     * @return null
     */
    public function output()
    {
        $this->trigger();

        return $this->output;
    }

    /**
     * Get the title.
     *
     * @return null
     */
    public function getTitle()
    {
        return $this->title;
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
     * Get the model object.
     *
     * @return null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the model object.
     *
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Set the wrapper view.
     *
     * @param $view
     */
    public function setWrapper($view)
    {
        $this->wrapper = $view;

        return $this;
    }

    /**
     * Return a new repository instance.
     *
     * @param UiAbstract $ui
     * @return Repository
     */
    protected function newRepository(UiAbstract $ui)
    {
        return new Repository($ui);
    }
}

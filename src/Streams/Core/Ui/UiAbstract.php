<?php namespace Streams\Core\Ui;

use Streams\Core\Traits\CallableTrait;

abstract class UiAbstract
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
     * The table wrapper view.
     *
     * @var string
     */
    protected $wrapperView = 'html/panel';

    /**
     * Prefix the UI to allow for
     * multiple instances on the same page.
     *
     * @var null
     */
    protected $prefix = null;

    /**
     * Make a model table.
     *
     * @param      $slug
     * @param null $namespace
     * @return $this
     */
    public function make($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Return the compiled the view output.
     *
     * @param bool $return
     * @return mixed
     */
    public function render()
    {
        $this->trigger();

        return \View::make(
            $this->wrapperView,
            [
                'title'   => \Lang::trans($this->title),
                'content' => $this->output,
            ]
        );
    }

    /**
     * Return the bare output without wrapping it.
     *
     * @return null
     */
    public function output()
    {
        $this->trigger();

        return $this->output;
    }

    /**
     * Set the title property.
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
     * Set the wrapper view.
     *
     * @param $wrapper
     * @return $this
     */
    public function setWrapperView($wrapperView)
    {
        $this->wrapperView = $wrapperView;

        return $this;
    }

    /**
     * Set the prefix;
     *
     * @param $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $prefix));

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
     * Render object when treated as a string
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->render();
    }
}

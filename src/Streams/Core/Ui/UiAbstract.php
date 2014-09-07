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
     * Return the compiled the view output.
     *
     * @param bool $return
     * @return mixed
     */
    public function render()
    {
        $this->trigger();

        return \View::make(
            'html/panel',
            array_merge(
                $this->table->make(),
                [
                    'content' => $this->output
                ]
            )
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
}

<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\Contract\RenderableInterface;

class Component implements RenderableInterface
{
    /**
     * Return the output.
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return (string)$this->render();
        } catch (\Exception $e) {
            die($e->getMessage() . ' - ' . get_called_class());
        }
    }

    /**
     * Return the output.
     *
     * @return null
     */
    public function render()
    {
        return null;
    }

    /**
     * Set the UI object.
     *
     * @param $ui
     * @return $this
     */
    public function setUi($ui)
    {
        $this->ui = $ui;

        return $this;
    }
}

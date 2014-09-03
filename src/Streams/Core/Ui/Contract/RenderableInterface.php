<?php namespace Streams\Core\Ui\Contract;

interface RenderableInterface
{
    /**
     * Return the output.
     *
     * @return string
     */
    public function render();

    /**
     * Render the output.
     *
     * @return string
     */
    public function __toString();
}

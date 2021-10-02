<?php

namespace Streams\Core\Transformer;

abstract class Renderer
{
    protected $intend = 0;

    protected $bodyIntend = 4;

    public function intend($intend)
    {
        $this->intend = $intend;
        return $this;
    }

    public function bodyIntend($bodyIntend)
    {
        $this->bodyIntend = $bodyIntend;
        return $this;
    }

    abstract public function render();

}

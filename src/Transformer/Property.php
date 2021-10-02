<?php

namespace Streams\Core\Transformer;

use phpDocumentor\Reflection\Type;

class Property extends Renderer
{
    /** @var string */
    public $name;

    /** @var string */
    public $type;

    /** @var string */
    public $description;

    /**
     * @param string $name
     * @param string $type
     * @param string $description
     */
    public function __construct(string $name, string $type, string $description = '')
    {
        $this->name        = $name;
        $this->type        = $type;
        $this->description = $description;
    }

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function type($type)
    {
        $this->type = $type;
    }

    public function description($description)
    {
        $this->description = $description;
    }

    public function render()
    {
        // TODO: Implement render() method.
    }

}

<?php

namespace Streams\Core\Transformer;

class Block extends Renderer
{
    const NAMESPACE = 'namespace';
    const CLASS = 'class';
    const INTERFACE = 'interface';
    const TYPE = 'type';

    /** @var string */
    protected $name;

    /** @var bool  */
    protected $exports = true;

    /** @var string */
    protected $extends;

    /** @var array|string[]  */
    protected $implements = [];

    /** @var \Streams\Core\Transformer\Property[]  */
    protected $properties = [];





    public function render()
    {
        // TODO: Implement render() method.
    }
}

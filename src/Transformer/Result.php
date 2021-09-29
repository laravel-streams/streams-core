<?php

namespace Streams\Core\Transformer;

use ReflectionClass;
use Spatie\TypeScriptTransformer\Structures\MissingSymbolsCollection;

class Result
{
    /** @var ReflectionClass */
    public $class;

    /** @var \Spatie\TypeScriptTransformer\Structures\MissingSymbolsCollection */
    public $missing;

    /** @var array */
    public $properties = [];

    /**
     * @param \ReflectionClass $class
     */
    public function __construct(ReflectionClass $class)
    {
        $this->class   = $class;
        $this->missing = new MissingSymbolsCollection();
    }

}

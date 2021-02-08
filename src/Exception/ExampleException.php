<?php

namespace Streams\Core\Exception;

use Exception;
use Facade\IgnitionContracts\Solution;
use Facade\IgnitionContracts\ProvidesSolution;
use Streams\Core\Exception\Solution\CopyExampleEnvSolution;

class ExampleException extends Exception
{
    use ProvidesSolution;

    public function getSolution(): Solution
    {
        return new CopyExampleEnvSolution;
    }
}

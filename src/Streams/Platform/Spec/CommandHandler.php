<?php namespace Streams\Platform\Spec;

use Streams\Platform\Contract\HandlerInterface;

class HandlerHandler implements HandlerInterface
{
    public function handle($command)
    {
        return $command->getTest();
    }
}
 
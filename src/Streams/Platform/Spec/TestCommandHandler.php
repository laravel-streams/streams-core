<?php namespace Streams\Platform\Spec;

use Streams\Platform\Contract\CommandInterface;

class TestCommandHandler implements CommandInterface
{
    public function handle($command)
    {
        return $command->getTest();
    }
}
 
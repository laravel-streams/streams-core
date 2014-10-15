<?php namespace Streams\Platform\Contract;

interface HandlerInterface
{
    /**
     * Handle the command.
     *
     * @param $command
     * @return mixed
     */
    public function handle($command);
}
 
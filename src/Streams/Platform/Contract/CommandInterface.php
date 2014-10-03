<?php namespace Streams\Platform\Contract;

interface CommandInterface
{
    /**
     * Handle the command.
     *
     * @param $command
     * @return mixed
     */
    public function handle($command);
}
 
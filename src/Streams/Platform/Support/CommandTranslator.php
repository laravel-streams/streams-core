<?php namespace Streams\Platform\Support;

class CommandTranslator
{
    /**
     * Translate a command to its handler counterpart.
     *
     * @param $command
     * @return mixed
     * @throws \Exception
     */
    public function toCommandHandler($command)
    {
        $commandClass = get_class($command);
        $handler      = substr_replace($commandClass, 'CommandHandler', strrpos($commandClass, 'Command'));

        if (!class_exists($handler)) {
            $message = "Command handler [$handler] does not exist.";

            throw new \Exception($message);
        }

        return $handler;
    }

    /**
     * Translate a command to its validator.
     *
     * @param $command
     * @return mixed
     * @throws \Exception
     */
    /*public function toCommandValidator($command)
    {
        $commandClass = get_class($command);
        $validator    = substr_replace($commandClass, 'CommandValidator', strrpos($commandClass, 'Command'));

        if (!class_exists($validator)) {
            $message = "Command validator [$validator] does not exist.";

            throw new \Exception($message);
        }

        return $validator;
    }*/
}

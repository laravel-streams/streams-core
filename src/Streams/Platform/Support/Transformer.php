<?php namespace Streams\Platform\Support;

class Transformer
{
    /**
     * Transform a class to its handler counterpart.
     *
     * @param $class
     * @return mixed
     * @throws \Exception
     */
    public function toHandler($class)
    {
        $class   = get_class($class);
        $handler = $class . 'Handler';

        if (!class_exists($handler)) {

            $message = "Handler [$handler] does not exist.";

            throw new \Exception($message);

        }

        return $handler;
    }

    /**
     * Transform a class to its validator counterpart.
     *
     * @param $class
     * @return mixed
     * @throws \Exception
     */
    public function toValidator($class)
    {
        $class     = get_class($class);
        $validator = $class . 'Validator';

        if (!class_exists($validator)) {

            $message = "Validator [$validator] does not exist.";

            throw new \Exception($message);

        }

        return $validator;
    }
}

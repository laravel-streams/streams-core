<?php namespace Streams\Platform\Support;

class Transformer
{
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

    public function toInstaller($class)
    {
        $class     = get_class($class);
        $installer = $class . 'Installer';

        if (!class_exists($installer)) {

            $message = "Installer [$installer] does not exist.";

            throw new \Exception($message);

        }

        return $installer;
    }
}

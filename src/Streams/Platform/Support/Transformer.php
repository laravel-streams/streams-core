<?php namespace Streams\Platform\Support;

class Transformer
{
    public function toHandler($class)
    {
        $class   = get_class($class);
        $handler = $class . 'Handler';

        if (!class_exists($handler)) {

            $handler = null;

        }

        return $handler;
    }

    public function toValidator($class)
    {
        $class     = get_class($class);
        $validator = $class . 'Validator';

        if (!class_exists($validator)) {

            $validator = null;

        }

        return $validator;
    }

    public function toInstaller($class)
    {
        $class     = get_class($class);
        $installer = $class . 'Installer';

        if (!class_exists($installer)) {

            $installer = null;

        }

        return $installer;
    }
}

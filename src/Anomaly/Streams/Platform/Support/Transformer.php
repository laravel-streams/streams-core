<?php namespace Anomaly\Streams\Platform\Support;

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

    public function toServiceProvider($class)
    {
        $class    = get_class($class);
        $provider = $class . 'ServiceProvider';

        if (!class_exists($provider)) {

            $provider = null;

        }

        return $provider;
    }

    public function toPresenter($class)
    {
        $class     = get_class($class);
        $presenter = $class . 'Presenter';

        if (!class_exists($presenter)) {

            $presenter = null;

        }

        return $presenter;
    }
}

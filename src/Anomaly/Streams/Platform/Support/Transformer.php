<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Transformer
 * A utility to return transformed classes
 * or NULL if the class does not exist.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Transformer
{

    /**
     * Transform a class to
     * it's corresponding handler.
     *
     * @param $class
     * @return null|string
     */
    public function toHandler($class)
    {
        $class   = get_class($class);
        $handler = $class . 'Handler';

        if (!class_exists($handler)) {

            $handler = null;
        }

        return $handler;
    }

    /**
     * Transform a class to
     * it's corresponding validator.
     *
     * @param $class
     * @return null|string
     */
    public function toValidator($class)
    {
        $class     = get_class($class);
        $validator = $class . 'Validator';

        if (!class_exists($validator)) {

            $validator = null;
        }

        return $validator;
    }

    /**
     * Transform a class to
     * it's corresponding installer.
     *
     * @param $class
     * @return null|string
     */
    public function toInstaller($class)
    {
        $class     = get_class($class);
        $installer = $class . 'Installer';

        if (!class_exists($installer)) {

            $installer = null;
        }

        return $installer;
    }

    /**
     * Transform a class to
     * it's corresponding service provider.
     *
     * @param $class
     * @return null|string
     */
    public function toServiceProvider($class)
    {
        $class    = get_class($class);
        $provider = $class . 'ServiceProvider';

        if (!class_exists($provider)) {

            $provider = null;
        }

        return $provider;
    }

    /**
     * Transform a class to
     * it's corresponding presenter.
     *
     * @param $class
     * @return null|string
     */
    public function toPresenter($class)
    {
        $class     = get_class($class);
        $presenter = $class . 'Presenter';

        if (!class_exists($presenter)) {

            $presenter = null;
        }

        return $presenter;
    }

    /**
     * Transform a class to
     * it's corresponding filter.
     *
     * @param $class
     * @return null|string
     */
    public function toFilter($class)
    {
        $class  = get_class($class);
        $filter = $class . 'Filter';

        if (!class_exists($filter)) {

            $filter = null;
        }

        return $filter;
    }
}

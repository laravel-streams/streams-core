<?php namespace Streams\Platform\Foundation;

use Illuminate\Container\Container;
use Streams\Platform\Manager\AddonManagerAbstract;

class AddonTypes
{
    /**
     * Addon types array, type  as and class value
     *
     * @var array
     */
    protected $addonTypes = [];

    /**
     * @param array $addonTypes
     */
    public function __construct($addonTypes = [])
    {
        foreach ($addonTypes as $type) {
            $this->addonTypes[$type] = $this->getAddonTypeManagerClass($type);
        }
    }

    /**
     * Get addon type manager class
     *
     * @param $type
     * @return string
     */
    public function getAddonTypeManagerClass($type)
    {
        return 'Streams\Platform\Addon\Manager\\' . studly_case(str_singular($type)) . 'Manager';
    }

    /**
     * Get addon types array
     *
     * @return array
     */
    public function all()
    {
        return $this->addonTypes;
    }

    /**
     * Register all addons using each addon type manager
     */
    public function register(Container $app)
    {
        foreach ($this->addonTypes as $type => $class) {
            /** @var $manager AddonManagerAbstract */
            $manager = new $class($app['streams.classloader'], $app['files']);

            \App::instance('streams.' . $type, $manager);

            $manager->register($app);
        }
    }

    /**
     * Boot
     */
    public function boot(Container $app)
    {
        $this->bindRepositories($app);
    }

    /**
     * Bind the repository class for an addon.
     *
     * @param $type
     */
    protected function bindRepositories(Container $app)
    {
        foreach ($this->addonTypes as $type => $class) {
            $classSegment = studly_case(str_singular($type));

            $interface  = 'Streams\Addon\Module\Addons\Contract\\' . $classSegment . 'RepositoryInterface';
            $repository = 'Streams\Addon\Module\Addons\Repository\Streams' . $classSegment . 'Repository';

            $app->singleton($interface, $repository);
        }
    }

    /**
     * Get addon types.
     *
     * @return array
     */
    public function getAddonTypes()
    {
        return $this->addonTypes;
    }
}
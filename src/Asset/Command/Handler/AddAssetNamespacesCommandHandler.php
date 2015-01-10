<?php namespace Anomaly\Streams\Platform\Asset\Command;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Asset\Asset;
use Illuminate\Container\Container;

/**
 * Class AddAssetNamespacesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset\Command
 */
class AddAssetNamespacesCommandHandler
{

    /**
     * The asset utility.
     *
     * @var Asset
     */
    protected $asset;

    /**
     * The application container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The streams application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new AddAssetNamespacesCommandHandler instance.
     *
     * @param Asset       $asset
     * @param Container   $container
     * @param Application $application
     */
    public function __construct(Asset $asset, Container $container, Application $application)
    {
        $this->asset       = $asset;
        $this->container   = $container;
        $this->application = $application;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->container->instance(
            'streams.asset.path',
            $this->container->make('path.public') . '/assets/' . $this->application->getReference()
        );

        $assets    = $this->container->make('streams.asset.path');
        $resources = $this->container->make('streams.path') . '/resources';

        $this->asset->addNamespace('asset', $assets);
        $this->asset->addNamespace('streams', $resources);
    }
}

<?php namespace Anomaly\Streams\Platform\Addon\Command\Handler;


use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Command\GetAddonByNamespace;

class GetAddonByNamespaceHandler
{

    /**
     * @var AddonCollection
     */
    protected $addons;

    /**
     * @param AddonCollection $addons
     */
    public function __construct(AddonCollection $addons)
    {
        $this->addons = $addons;
    }

    /**
     * @param GetAddonByNamespace $command
     *
     * @return Addon|null
     */
    public function handle(GetAddonByNamespace $command)
    {
        return $this->addons->merged()->get($command->getNamespace());
    }
}

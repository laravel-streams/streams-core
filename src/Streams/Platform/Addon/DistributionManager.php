<?php namespace Streams\Platform\Addon;

use Streams\Platform\Addon\Collection\DistributionCollection;
use Streams\Platform\Addon\Model\DistributionModel;

class DistributionManager extends AddonManager
{
    /**
     * The folder within addons locations to load distributions from.
     *
     * @var string
     */
    protected $folder = 'distributions';

    /**
     * Enable storage?
     *
     * @var bool
     */
    protected $storage = false;

    /**
     * Return a new model instance.
     *
     * @return mixed
     */
    protected function newModel()
    {
        return new DistributionModel();
    }

    /**
     * Return a new collection instance.
     *
     * @param array $distributions
     * @return null|DistributionCollection
     */
    protected function newCollection(array $distributions = [])
    {
        return new DistributionCollection($distributions);
    }
}

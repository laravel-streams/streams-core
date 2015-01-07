<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

/**
 * Class DistributionPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution
 */
class DistributionPluginFunctions
{

    /**
     * The distribution collection.
     *
     * @var DistributionCollection
     */
    protected $distributions;

    /**
     * Create a new DistributionPluginFunctions instance.
     *
     * @param DistributionCollection $distributions
     */
    public function __construct(DistributionCollection $distributions)
    {
        $this->distributions = $distributions;
    }

    /**
     * Return the active distribution.
     *
     * @return Distribution
     */
    public function distribution()
    {
        return $this->distributions->active();
    }
}

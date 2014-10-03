<?php namespace Streams\Platform\Addon\Distribution;

use Streams\Platform\Addon\AddonManager;

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
}

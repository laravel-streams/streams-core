<?php namespace Streams\Platform\Addon\Block;

use Streams\Platform\Addon\AddonManager;

class BlockManager extends AddonManager
{
    /**
     * The folder within addons locations to load blocks from.
     *
     * @var string
     */
    protected $folder = 'blocks';
}

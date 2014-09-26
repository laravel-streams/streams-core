<?php namespace Streams\Platform\Addon\Tag;

use Streams\Platform\Addon\TagAbstract;
use Streams\Platform\Addon\AddonAbstract;

class AddonTag extends TagAbstract
{
    /**
     * The addon object.
     *
     * @var \Streams\Platform\Addon\AddonAbstract
     */
    protected $addon;

    /**
     * Create a new AddonTag instance.
     *
     * @param AddonAbstract $addon
     */
    public function __construct(AddonAbstract $addon)
    {
        $this->addon = $addon;
    }
}
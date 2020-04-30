<?php

namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class Extension
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Extension extends Addon
{

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;


    /**
     * Get the provides string.
     *
     * @return null|string
     */
    public function provides()
    {
        return array_get($this->getComposerJson(), 'extra.streams.provides');
    }

    /**
     * Return the addon as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            [
                'enabled'   => $this->enabled,
                'installed' => $this->installed,
                'provides'  => $this->provides(),
            ]
        );
    }
}

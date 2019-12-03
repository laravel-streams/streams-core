<?php

namespace Anomaly\Streams\Platform\Ui\Contract;

use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;

/**
 * Interface IconInterface
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface IconInterface
{

    /**
     * Get the icon.
     *
     * @return string
     */
    public function getIcon();

    /**
     * Set the icon.
     *
     * @param array $icon
     * @return $this
     */
    public function setIcon($icon);

    /**
     * Return icon HTML.
     *
     * @param array $icon
     * @return null|string
     */
    public function icon();
}

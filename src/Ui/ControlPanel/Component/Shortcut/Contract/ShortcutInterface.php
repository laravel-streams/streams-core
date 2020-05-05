<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\Contract;

/**
 * Interface ShortcutInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface ShortcutInterface
{

    /**
     * Return the HREF.
     *
     * @param  null $path
     * @return string
     */
    public function href($path = null);
}

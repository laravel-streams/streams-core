<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;

/**
 * Interface SectionInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface SectionInterface
{

    /**
     * Return the HREF attribute.
     *
     * @param  null $path
     * @return string
     */
    public function href($path = null);
}

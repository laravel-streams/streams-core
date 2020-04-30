<?php

namespace Anomaly\Streams\Platform\Ui\Button\Contract;

/**
 * Interface ButtonInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface ButtonInterface
{

    /**
     * Return the open tag.
     *
     * @param array $attributes
     * @return string
     */
    public function open(array $attributes = []);

    /**
     * Return the close tag.
     *
     * @return string
     */
    public function close();
}

<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Closure;

/**
 * Interface FilterInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface FilterInterface
{

    /**
     * Get the filter input.
     *
     * @return null|string
     */
    public function getInput();

    /**
     * Get the filter name.
     *
     * @return string
     */
    public function getInputName();

    /**
     * Get the filter value.
     *
     * @return null|string
     */
    public function getValue();
}

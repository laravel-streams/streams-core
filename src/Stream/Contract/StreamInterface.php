<?php

namespace Anomaly\Streams\Platform\Stream\Contract;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;

/**
 * Interface StreamInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface StreamInterface
{

    /**
     * Return the title field.
     *
     * @return null|FieldInterface
     */
    public function titleField();
}

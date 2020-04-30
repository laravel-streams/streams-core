<?php

namespace Anomaly\Streams\Platform\Field\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Interface FieldInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface FieldInterface
{

    /**
     * Return the field's type.
     *
     * @return FieldType
     */
    public function type();
}

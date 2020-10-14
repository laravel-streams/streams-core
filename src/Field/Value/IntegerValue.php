<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * Class IntegerValue
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class IntegerValue extends Value
{

    /**
     * Return if the number is even.
     *
     * @return bool
     */
    public function isEven()
    {
        return $this->value % 2 == 0;
    }

    /**
     * Return if the number is odd.
     *
     * @return bool
     */
    public function isOdd()
    {
        return $this->value % 2 != 0;
    }
}

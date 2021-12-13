<?php

namespace Streams\Core\Support\Macros;

/**
 * @param mixed $key
 * @return bool
 */
class CollectionHasAny
{
    public function __invoke()
    {
        return
            /**
             * @param mixed $key
             * @return bool
             */ function ($key) {

            $keys = is_array($key) ? $key : func_get_args();

            foreach ($keys as $value) {
                if ($this->has($value)) {
                    return true;
                }
            }

            return false;
        };
    }

}

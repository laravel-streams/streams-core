<?php

namespace Anomaly\Streams\Platform\Support;

use ArrayAccess;
use IteratorAggregate;
use Anomaly\Streams\Platform\Presenter\Contract\PresentableInterface;

/**
 * Class Decorator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Decorator
{

    /*
     * Decorate a value.
     *
     * @param  mixed $value
     * @return mixed $value
    */
    public static function decorate($value)
    {
        if (is_object($value) && method_exists($value, 'newPresenter')) {
            return $value->newPresenter();
        }

        if (is_array($value) or ($value instanceof IteratorAggregate and $value instanceof ArrayAccess)) {
            foreach ($value as $k => $v) {
                $value[$k] = self::decorate($v);
            }
        }

        return $value;
    }

    /**
     * Undecorate a value.
     *
     * @param $value
     * @return mixed
     */
    public static function undecorate($value)
    {
        if ($value instanceof Presenter) {
            return $value->getObject();
        }

        if (is_array($value) || ($value instanceof IteratorAggregate && $value instanceof ArrayAccess)) {
            foreach ($value as $k => $v) {
                $value[$k] = self::undecorate($v);
            }
        }

        return $value;
    }
}

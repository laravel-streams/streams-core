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
class Decorator extends \Robbo\Presenter\Decorator
{

    /*
     * Decorate a value.
     *
     * @param  mixed $value
     * @return mixed $value
    */
    public function decorate($value)
    {
        if ($value instanceof PresentableInterface) {
            return $value->getPresenter();
        }

        if (is_array($value) or ($value instanceof IteratorAggregate and $value instanceof ArrayAccess)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->decorate($v);
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
                $value[$k] = $this->undecorate($v);
            }
        }

        return $value;
    }
}

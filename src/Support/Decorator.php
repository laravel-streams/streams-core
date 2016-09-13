<?php namespace Anomaly\Streams\Platform\Support;

use ArrayAccess;
use IteratorAggregate;

/**
 * Class Decorator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class Decorator extends \Robbo\Presenter\Decorator
{

    /**
     * Undecorate a value.
     *
     * @param $value
     * @return mixed
     */
    public function undecorate($value)
    {
        if ($value instanceof Presenter) {
            return $value->getObject();
        }

        if (is_array($value) or ($value instanceof IteratorAggregate and $value instanceof ArrayAccess)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->decorate($v);
            }
        }

        return $value;
    }
}

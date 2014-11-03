<?php namespace Anomaly\Streams\Platform\Traits;

use Anomaly\Streams\Platform\Support\Transformer;

/**
 * Class TransformableTrait
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Traits
 */
trait TransformableTrait
{

    /**
     * Transform a class to a counterpart with
     * the specified class suffix.
     *
     * @param      $suffix
     * @param null $class
     * @return null|string
     */
    public function transform($suffix, $class = null)
    {
        if (substr($suffix, 0, 2) == 'to') {

            $suffix = substr($suffix, 2);
        }

        if (!$class) {

            $class = $this;
        }

        return (new Transformer())->to($class, $suffix);
    }
}
 
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
     * @param $suffix
     * @return null|string
     */
    public function transform($suffix)
    {
        if (substr($suffix, 0, 2) === 'to') {

            $suffix = substr($suffix, 2);
        }

        return (new Transformer())->to($this, $suffix);
    }
}
 
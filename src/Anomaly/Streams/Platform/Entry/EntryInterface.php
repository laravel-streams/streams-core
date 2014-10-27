<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Contract\ArrayableInterface;

/**
 * Interface EntryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
interface EntryInterface extends ArrayableInterface
{

    /**
     * @param $field
     * @return mixed
     */
    public function getValueFromField($field);

}
 
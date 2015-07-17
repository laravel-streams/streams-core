<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class FieldTypeManager
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeManager
{

    use DispatchesJobs;

    /**
     * A simple public API for the builder command.
     *
     * @param  array $data
     * @return mixed
     */
    public function build(array $data)
    {
        return $this->dispatchFromArray(
            'Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldType',
            $data
        );
    }
}

<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class FieldTypeManager
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
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

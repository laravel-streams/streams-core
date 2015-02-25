<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldType;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class FieldTypeBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeBuilder
{

    use DispatchesCommands;

    /**
     * Build a field type.
     *
     * @param array $parameters
     * @return FieldType
     */
    public function build(array $parameters)
    {
        return $this->dispatch(new BuildFieldType($parameters));
    }
}

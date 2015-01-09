<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

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
     * @param array $field
     * @return FieldType
     */
    public function build(array $field)
    {
        return $this->dispatchFromArray(
            'Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldTypeCommand',
            $field
        );
    }
}

<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

    /**
     * Build a field type.
     *
     * @param array $field
     * @return FieldType
     */
    public function build(array $field)
    {
        return $this->execute('\Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldTypeCommand', $field);
    }
}

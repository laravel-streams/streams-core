<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Laracasts\Commander\CommanderTrait;

/**
 * Class FieldTypeService
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeService
{
    use CommanderTrait;

    /**
     * A simple public API for the builder command.
     *
     * @param array $data
     * @return mixed
     */
    public function build(array $data)
    {
        return $this->execute('Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldTypeCommand', $data);
    }
}

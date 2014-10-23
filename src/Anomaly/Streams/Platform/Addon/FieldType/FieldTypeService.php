<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldTypeCommand;

class FieldTypeService
{
    use CommandableTrait;

    public function build($data)
    {
        $command = new BuildFieldTypeCommand();

        return $this->execute($command);
    }
}
 
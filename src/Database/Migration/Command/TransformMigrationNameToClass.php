<?php

namespace Anomaly\Streams\Platform\Database\Migration\Command;

/**
 * Class TransformMigrationNameToClass.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class TransformMigrationNameToClass
{
    /**
     * The migration name.
     *
     * @var string
     */
    protected $name;

    /**
     * Create a new TransformMigrationNameToClass instance.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}

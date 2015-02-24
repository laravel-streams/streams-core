<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

class TransformMigrationNameToClass
{

    protected $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

}
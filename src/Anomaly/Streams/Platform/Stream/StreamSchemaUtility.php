<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;

class StreamSchemaUtility
{
    /**
     * Create a new StreamSchemaUtility instance.
     */
    public function __construct()
    {
        $this->streams     = new StreamModel();
        $this->fields      = new FieldModel();
        $this->assignments = new AssignmentModel();
    }

    /**
     * Destroy a stream namespace.
     *
     * @param $namespace
     * @return bool
     */
    public function destroyNamespace($namespace)
    {
        $this->streams->findAllByNamespace($namespace)->delete();
        $this->fields->findAllByNamespace($namespace)->delete();

        return true;
    }

    /**
     * Clean up any garbage sitting around.
     */
    public function cleanup()
    {
        $this->fields->findAllOrphaned()->delete();
        $this->assignments->findAllOrphaned()->delete();
    }
}

<?php namespace Streams\Platform\Stream\Utility;


use Streams\Platform\Assignment\Model\AssignmentModel;
use Streams\Platform\Field\Model\FieldModel;
use Streams\Platform\Stream\Model\StreamModel;

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
        // @todo - We need a more elegant design than this.
        // Call delete on the collections to iterate over items.
        $this->streams->findAllByNamespace($namespace)->delete();
        $this->fields->findAllByNamespace($namespace)->delete();

        // @todo - put these in a maintenance method (heavy)
        /*$this->fields->cleanup();
        $this->assignments->cleanup();*/

        return true;
    }
}

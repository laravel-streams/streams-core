<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class StreamUtility
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamUtility
{
    /**
     * The fields repository interface.
     *
     * @var \Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface
     */
    protected $fields;

    /**
     * The streams repository interface
     *
     * @var Contract\StreamRepositoryInterface
     */
    protected $streams;

    /**
     * The assignments repository interface
     *
     * @var \Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface
     */
    protected $assignments;

    /**
     * Create a new StreamUtility instance.
     *
     * @param FieldRepositoryInterface      $fields
     * @param StreamRepositoryInterface     $streams
     * @param AssignmentRepositoryInterface $assignments
     */
    public function __construct(
        FieldRepositoryInterface $fields,
        StreamRepositoryInterface $streams,
        AssignmentRepositoryInterface $assignments
    ) {
        $this->fields      = $fields;
        $this->streams     = $streams;
        $this->assignments = $assignments;
    }

    /**
     * Destroy a stream namespace.
     *
     * @param $namespace
     */
    public function destroyNamespace($namespace)
    {
        // TODO: Verify this deletes each individually.
        $this->streams->getAllWithNamespace($namespace)->delete();
        $this->fields->getAllWithNamespace($namespace)->delete();
    }

    /**
     * Clean up any garbage sitting around.
     */
    public function cleanup()
    {
        $this->fields->deleteGarbage();
        $this->assignments->deleteGarbage();
    }
}

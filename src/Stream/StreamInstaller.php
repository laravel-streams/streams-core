<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Contract\InstallableInterface;
use Anomaly\Streams\Platform\Field\FieldManager;

/**
 * Class StreamInstaller
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamInstaller implements InstallableInterface
{

    /**
     * The stream configuration.
     *
     * @var array
     */
    protected $stream = [];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [];

    /**
     * The stream service.
     *
     * @var StreamManager
     */
    protected $streamManager;

    /**
     * The field service.
     *
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * The addon object.
     *
     * @var Addon
     */
    protected $addon;

    /**
     * Create a new StreamInstaller instance.
     *
     * @param StreamManager $streamManager
     * @param FieldManager  $fieldManager
     */
    public function __construct(StreamManager $streamManager, FieldManager $fieldManager, Addon $addon)
    {
        $this->addon         = $addon;
        $this->fieldManager  = $fieldManager;
        $this->streamManager = $streamManager;

        if (is_string($this->stream)) {
            $this->stream = ['slug' => $this->stream];
        }
    }

    /**
     * Install a stream and it's assignments.
     */
    public function install()
    {
        $this->installStream();

        // Process the assignment.
        foreach ($this->getAssignments() as $field => $assignment) {
            $this->assignField($field, $assignment);
        }
    }

    /**
     * Uninstall a stream and it's assignments.
     */
    public function uninstall()
    {
        $stream    = array_get($this->stream, 'slug');
        $namespace = array_get($this->stream, 'namespace', $this->addon->getSlug());

        foreach ($this->getAssignments() as $field => $assignment) {
            $this->fieldManager->unassign($namespace, $stream, $field, $assignment);
        }

        $this->streamManager->delete($namespace, $stream);
    }

    /**
     * Install the stream.
     */
    protected function installStream()
    {
        $slug        = array_get($this->stream, 'slug');
        $namespace   = array_get($this->stream, 'namespace', $this->addon->getSlug());
        $name        = array_get($this->stream, 'name', $this->addon->getKey("stream.{$slug}.name"));
        $description = array_get($this->stream, 'name', $this->addon->getKey("stream.{$slug}.description"));

        $orderBy     = array_get($this->stream, 'order_by', 'id');
        $titleColumn = array_get($this->stream, 'title_column', 'id');

        $locked       = (array_get($this->stream, 'locked', false));
        $translatable = (array_get($this->stream, 'translatable', false));

        $prefix      = array_get($this->stream, 'prefix', $namespace . '_');
        $viewOptions = array_get($this->stream, 'view_options', ['id', 'created_at']);

        $stream = compact(
            'slug',
            'name',
            'locked',
            'prefix',
            'orderBy',
            'namespace',
            'titleColumn',
            'viewOptions',
            'description',
            'translatable'
        );

        // Create the stream.
        $this->streamManager->create($stream);
    }

    /**
     * Assign a field.
     *
     * @param $field
     * @param $assignment
     */
    protected function assignField($field, $assignment)
    {
        if (is_string($assignment)) {
            $field      = $assignment;
            $assignment = [];
        }

        $unique       = (array_get($assignment, 'unique', false));
        $required     = (array_get($assignment, 'required', false));
        $translatable = (array_get($assignment, 'translatable', false));

        $label        = array_get($assignment, 'label', $this->addon->getKey("field.{$field}.label"));
        $placeholder  = array_get($assignment, 'placeholder', $this->addon->getKey("field.{$field}.placeholder"));
        $instructions = array_get($assignment, 'instructions', $this->addon->getKey("field.{$field}.instructions"));

        $assignment = compact('label', 'placeholder', 'instructions', 'unique', 'required', 'translatable');

        $stream    = array_get($this->stream, 'slug');
        $namespace = array_get($this->stream, 'namespace', $this->addon->getSlug());

        $this->fieldManager->assign(
            $namespace,
            $stream,
            $field,
            $assignment
        );
    }

    /**
     * Get the stream assignments.
     *
     * @return array
     */
    protected function getAssignments()
    {
        return $this->assignments;
    }
}

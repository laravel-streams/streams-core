<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Contract\InstallableInterface;
use Anomaly\Streams\Platform\Field\FieldService;

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
     * The addon type.
     *
     * @var null
     */
    protected $addonType = null;

    /**
     * The default namespace.
     *
     * @var null
     */
    protected $namespace = null;

    /**
     * The default slug.
     *
     * @var null
     */
    protected $slug = null;

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
     * @var StreamService
     */
    protected $streamService;

    /**
     * The field service.
     *
     * @var \Anomaly\Streams\Platform\Field\FieldService
     */
    protected $fieldService;

    /**
     * Create a new StreamInstaller instance.
     *
     * @param StreamService $streamService
     * @param FieldService  $fieldService
     */
    public function __construct(StreamService $streamService, FieldService $fieldService)
    {
        $this->fieldService  = $fieldService;
        $this->streamService = $streamService;

        $this->setSlug();
        $this->setNamespace();
        $this->setAddonType();

        $this->boot();
    }

    /**
     * Set up the class.
     */
    protected function boot()
    {
        //
    }

    /**
     * Install a stream and it's assignments.
     */
    public function install()
    {
        $this->stream['slug']      = $this->getStreamSlug();
        $this->stream['namespace'] = $this->getStreamNamespace();

        $this->stream['name']        = $this->getStreamName();
        $this->stream['description'] = $this->getStreamDescription();

        // Add the stream.
        $this->streamService->create($this->stream);

        // Assign each of the assignments.
        foreach ($this->getAssignments() as $field => $assignment) {

            if (is_string($assignment)) {
                $field      = $assignment;
                $assignment = [];
            }

            $isUnique       = array_get($assignment, 'is_unique', false);
            $isRequired     = array_get($assignment, 'is_required', false);
            $isTranslatable = array_get($assignment, 'is_translatable', false);

            $label        = $this->getAssignmentLabel($assignment, $field);
            $placeholder  = $this->getAssignmentPlaceholder($assignment, $field);
            $instructions = $this->getAssignmentInstructions($assignment, $field);

            $assignment = compact('label', 'placeholder', 'instructions', 'isUnique', 'isRequired', 'isTranslatable');

            $this->fieldService->assign(
                $this->stream['namespace'],
                $this->stream['slug'],
                $field,
                $assignment
            );
        }
    }

    /**
     * Uninstall a stream and it's assignments.
     */
    public function uninstall()
    {
        $this->stream['slug']      = $this->getStreamSlug();
        $this->stream['namespace'] = $this->getStreamNamespace();

        foreach ($this->getAssignments() as $field => $assignment) {

            $this->fieldService->unassign(
                $this->stream['namespace'],
                $this->stream['slug'],
                $field,
                $assignment
            );
        }

        $this->streamService->delete($this->stream['namespace'], $this->stream['slug']);
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

    /**
     * Get the stream slug.
     *
     * @return null
     */
    protected function getStreamSlug()
    {
        return (isset($this->stream['slug'])) ? $this->stream['slug'] : $this->slug;
    }

    /**
     * Get the stream namespace.
     *
     * @return null
     */
    protected function getStreamNamespace()
    {
        return (isset($this->stream['namespace'])) ? $this->stream['namespace'] : $this->namespace;
    }

    /**
     * Get the stream name.
     *
     * @return string
     */
    protected function getStreamName()
    {
        $default = "{$this->addonType}.{$this->stream['namespace']}::stream.{$this->stream['slug']}.name";

        return isset($stream['name']) ? $stream['name'] : $default;
    }

    /**
     * Get the stream description.
     *
     * @return string
     */
    protected function getStreamDescription()
    {
        $default = "{$this->addonType}.{$this->stream['namespace']}::stream.{$this->stream['slug']}.description";

        return isset($stream['description']) ? $stream['description'] : $default;
    }

    /**
     * Get the assignment label.
     *
     * @param $assignment
     * @param $field
     * @return string
     */
    protected function getAssignmentLabel($assignment, $field)
    {
        $default = "{$this->addonType}.{$this->stream['namespace']}::field.{$field}.label";

        return isset($assignment['label']) ? $assignment['label'] : $default;
    }

    /**
     * Get the assignment placeholder.
     *
     * @param $assignment
     * @param $field
     * @return string
     */
    protected function getAssignmentPlaceholder($assignment, $field)
    {
        $default = "{$this->addonType}.{$this->stream['namespace']}::field.{$field}.placeholder";

        return isset($assignment['placeholder']) ? $assignment['placeholder'] : $default;
    }

    /**
     * Get the assignment instructions.
     *
     * @param $assignment
     * @param $field
     * @return string
     */
    protected function getAssignmentInstructions($assignment, $field)
    {
        $default = "{$this->addonType}.{$this->stream['namespace']}::field.{$field}.instructions";

        return isset($assignment['instructions']) ? $assignment['instructions'] : $default;
    }

    /**
     * Get the assignment namespace.
     *
     * @param $assignment
     * @return mixed
     */
    protected function getAssignmentNamespace($assignment)
    {
        return isset($assignment['namespace']) ? $assignment['namespace'] : $this->stream['namespace'];
    }

    /**
     * Set the addon type.
     */
    protected function setAddonType()
    {
        if (!$this->addonType) {

            $addonType = explode('\\', (new \ReflectionClass($this))->getName());

            $this->addonType = snake_case($addonType[3]);
        }
    }

    /**
     * Set the default namespace.
     */
    protected function setNamespace()
    {
        if (!$this->namespace) {

            $namespace = explode('\\', (new \ReflectionClass($this))->getName());

            $this->namespace = snake_case($namespace[4]);
        }
    }

    /**
     * Set the default slug.
     */
    protected function setSlug()
    {
        if (!$this->slug) {

            $slug = (new \ReflectionClass($this))->getShortName();
            $slug = str_replace('StreamInstaller', null, $slug);

            $this->slug = snake_case($slug);
        }
    }
}

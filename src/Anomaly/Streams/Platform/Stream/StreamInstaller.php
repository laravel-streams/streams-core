<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Field\FieldService;

class StreamInstaller
{
    protected $addonType = null;

    protected $namespace = null;

    protected $slug = null;

    protected $stream = [];

    protected $assignments = [];

    protected $streamService;

    protected $fieldService;

    public function __construct(StreamService $streamService, FieldService $fieldService)
    {
        $this->fieldService  = $fieldService;
        $this->streamService = $streamService;

        $this->setAddonType();
        $this->setNamespace();
        $this->setSlug();
    }

    public function install()
    {
        $this->stream['slug']      = $this->getStreamSlug();
        $this->stream['namespace'] = $this->getStreamNamespace();

        $this->stream['name']        = $this->getStreamName();
        $this->stream['description'] = $this->getStreamDescription();

        // Add the stream.
        $this->streamService->add($this->stream);

        // Assign each of the assignments.
        foreach ($this->getAssignments() as $field => $assignment) {

            $assignment['instructions'] = $this->getAssignmentInstructions($assignment, $field);

            $this->fieldService->assign(
                $this->stream['namespace'],
                $this->stream['slug'],
                $field,
                $assignment
            );
        }
    }

    public function uninstall()
    {
        $slug      = $this->stream['slug'];
        $namespace = $this->stream['namespace'];

        // Unassign each of the assignments.
        foreach ($this->getAssignments() as $field => $assignment) {
            $this->fieldService->unassign(
                $namespace,
                $slug,
                $field,
                $assignment
            );
        }

        // Remove the stream.
        $this->streamService->remove($namespace, $slug);
    }

    protected function getAssignments()
    {
        return $this->assignments;
    }

    protected function getStreamSlug()
    {
        return (isset($this->stream['slug'])) ? $this->stream['slug'] : $this->slug;
    }

    protected function getStreamNamespace()
    {
        return (isset($this->stream['namespace'])) ? $this->stream['namespace'] : $this->namespace;
    }

    protected function getStreamName()
    {
        $default = "{$this->addonType}.{$this->stream['namespace']}::stream.{$this->stream['slug']}.name";

        return isset($stream['name']) ? $stream['name'] : $default;
    }

    protected function getStreamDescription()
    {
        $default = "{$this->addonType}.{$this->stream['namespace']}::stream.{$this->stream['slug']}.description";

        return isset($stream['description']) ? $stream['description'] : $default;
    }

    protected function getAssignmentInstructions($assignment, $field)
    {
        $default = "{$this->addonType}.{$this->stream['namespace']}::field.{$field}.instructions";

        return isset($assignment['instructions']) ? $assignment['instructions'] : $default;
    }

    protected function getAssignmentNamespace($assignment)
    {
        return isset($assignment['namespace']) ? $assignment['namespace'] : $this->stream['namespace'];
    }

    protected function setAddonType()
    {
        if (!$this->addonType) {

            $addonType = explode('\\', (new \ReflectionClass($this))->getName());

            $this->addonType = snake_case($addonType[3]);

        }
    }

    protected function setNamespace()
    {
        if (!$this->namespace) {

            $namespace = explode('\\', (new \ReflectionClass($this))->getName());

            $this->namespace = snake_case($namespace[4]);

        }
    }

    protected function setSlug()
    {
        if (!$this->slug) {

            $slug = (new \ReflectionClass($this))->getShortName();
            $slug = str_replace('StreamInstaller', null, $slug);

            $this->slug = snake_case($slug);

        }
    }
}

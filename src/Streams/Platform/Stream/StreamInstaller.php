<?php namespace Streams\Platform\Stream;

use Streams\Platform\Support\Installer;
use Streams\Platform\Field\FieldService;
use Streams\Platform\Addon\AddonAbstract;

class StreamInstaller extends Installer
{
    /**
     * The stream to install.
     *
     * @var array
     */
    protected $stream = [];

    /**
     * The field assignments to install.
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
     * @var \Streams\Platform\Field\FieldService
     */
    protected $fieldService;

    /**
     * Create a new StreamInstaller instance.
     *
     * @param AddonAbstract $addon
     * @param StreamService  $streamService
     * @param FieldService   $fieldService
     */
    public function __construct(
        AddonAbstract $addon,
        StreamService $streamService,
        FieldService $fieldService
    ) {
        $this->addon         = $addon;
        $this->streamService = $streamService;
        $this->fieldService  = $fieldService;
    }

    /**
     * Add a stream and it's assignments.
     */
    public function install()
    {
        // Determine a namespace if not provided.
        if (!isset($this->stream['namespace'])) {
            $this->stream['namespace'] = $this->addon->getSlug();
        }

        // Determine a slug if not provided.
        if (!isset($this->stream['lang'])) {
            $this->stream['lang'] = $this->addon->getAbstract();
        }

        $slug      = $this->stream['slug'];
        $namespace = $this->stream['namespace'];

        // Add the stream.
        $stream = $this->streamService->add($this->stream);

        // Assign each of the assignments.
        foreach ($this->assignments as $field => $assignment) {

            // Catch some convenient defaults.
            if (!isset($assignment['lang'])) {
                $assignment['lang'] = $this->addon->getAbstract();
            }

            $this->fieldService->assign(
                $namespace,
                $slug,
                $field,
                $assignment
            );
        }
    }

    /**
     * Uninstall the stream and it's assignments.
     *
     * @return bool|void
     */
    public function uninstall()
    {
        // Determine a namespace if not provided.
        if (!isset($this->stream['namespace'])) {
            $this->stream['namespace'] = $this->addon->getSlug();
        }

        $slug      = $this->stream['slug'];
        $namespace = $this->stream['namespace'];

        // Unassign each of the assignments.
        foreach ($this->assignments as $field => $assignment) {
            $this->fieldService->unassign(
                $namespace,
                $slug,
                $field,
                $assignment
            );
        }

        // Remove the stream.
        $stream = $this->streamService->remove($namespace, $slug);
    }
}

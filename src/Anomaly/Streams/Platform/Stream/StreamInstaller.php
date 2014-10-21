<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Field\FieldService;
use Anomaly\Streams\Platform\Addon\Addon;

class StreamInstaller
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
     * @var \Anomaly\Streams\Platform\Field\FieldService
     */
    protected $fieldService;

    /**
     * Create a new StreamInstaller instance.
     *
     * @param StreamService $streamService
     * @param FieldService  $fieldService
     */
    public function __construct(
        StreamService $streamService,
        FieldService $fieldService
    ) {
        $this->streamService = $streamService;
        $this->fieldService  = $fieldService;
    }

    /**
     * Add a stream and it's assignments.
     */
    public function install()
    {
        $slug      = $this->stream['slug'];
        $namespace = $this->stream['namespace'];

        // Determine a lang namespace if not provided.
        if (!isset($this->stream['lang'])) {
            $this->stream['lang'] = 'module.' . $this->stream['namespace'];
        }

        // Add the stream.
        $this->streamService->add($this->stream);

        // Assign each of the assignments.
        foreach ($this->assignments as $field => $assignment) {

            // Catch some convenient defaults.
            if (!isset($assignment['lang'])) {
                $assignment['lang'] = $this->stream['lang'];
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
        $this->streamService->remove($namespace, $slug);
    }
}

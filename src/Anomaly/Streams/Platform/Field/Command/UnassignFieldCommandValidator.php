<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

class UnassignFieldCommandValidator
{

    /**
     * The fields repository.
     *
     * @var \Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface
     */
    protected $fields;

    /**
     * The streams repository.
     *
     * @var \Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface
     */
    protected $streams;

    /**
     * The assignments repository.
     *
     * @var \Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface
     */
    protected $assignments;

    /**
     * Create a new UnassignFieldCommandHandler instance.
     *
     * @param FieldRepositoryInterface  $fields
     * @param StreamRepositoryInterface $streams
     */
    public function __construct(
        FieldRepositoryInterface $fields,
        StreamRepositoryInterface $streams
    ) {
        $this->fields  = $fields;
        $this->streams = $streams;
    }

    /**
     * Handle the command.
     *
     * @param UnassignFieldCommand $command
     * @return mixed
     */
    public function handle(UnassignFieldCommand $command)
    {
        $namespace = $command->getNamespace();
        $stream    = $command->getStream();
        $field     = $command->getField();

        $stream = $this->streams->findByNamespaceAndSlug($namespace, $stream);
        $field  = $this->fields->findByNamespaceAndSlug($namespace, $field);

        if (!$stream) {
            throw new \Exception("Stream not found with namespace [{$namespace}] and slug [{$stream}]");
        }

        if (!$field) {
            throw new \Exception("Field not found with namespace [{$namespace}] and slug [{$field}]");
        }
    }
}

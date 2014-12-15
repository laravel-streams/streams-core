<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class AssignFieldCommandValidator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class AssignFieldCommandValidator
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
     * Create a new AssignFieldCommandHandler instance.
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
     * Validate the command.
     *
     * @param AssignFieldCommand $command
     * @throws \Exception
     */
    public function handle(AssignFieldCommand $command)
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

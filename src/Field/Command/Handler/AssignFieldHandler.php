<?php namespace Anomaly\Streams\Platform\Field\Command\Handler;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Command\AssignField;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class AssignFieldHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Command
 */
class AssignFieldHandler
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
     * The assignment repository.
     *
     * @var \Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface
     */
    protected $assignments;

    /**
     * Create a new AssignFieldHandler instance.
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
        $this->assignments = $assignments;
        $this->fields      = $fields;
        $this->streams     = $streams;
    }

    /**
     * Handle the command.
     *
     * @param  $command
     * @return $this|mixed
     */
    public function handle(AssignField $command)
    {
        $namespace = $command->getNamespace();
        $stream    = $command->getStream();
        $field     = $command->getField();

        $stream = $this->streams->findByNamespaceAndSlug($namespace, $stream);
        $field  = $this->fields->findByNamespaceAndSlug($namespace, $field);

        if (!$stream) {
            throw new \InvalidArgumentException(
                "The stream [{$command->getField()}] does not exist."
            );
        }

        if (!$field) {
            throw new \InvalidArgumentException(
                "The field [{$command->getField()}] does not exist in the stream [{$command->getStream()}]."
            );
        }

        return $this->assignments->create(
            $stream->getKey(),
            $field->getKey(),
            $command->getLabel(),
            $command->getInstructions(),
            $command->isUnique(),
            $command->isRequired(),
            $command->isTranslatable()
        );
    }
}

<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Laracasts\Commander\Events\DispatchableTrait;

/**
 * Class AssignFieldCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class AssignFieldCommandHandler
{

    use DispatchableTrait;

    protected $fields;

    protected $streams;

    protected $assignments;

    function __construct(
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
     * @param $command
     * @return $this|mixed
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

        return $this->assignments->create(
            $stream,
            $field,
            $command->getLabel(),
            $command->getPlaceholder(),
            $command->getInstructions(),
            $command->getIsUnique(),
            $command->getIsRequired(),
            $command->getIsTranslatable()
        );
    }
}
 
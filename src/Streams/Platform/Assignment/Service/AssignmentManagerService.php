<?php namespace Streams\Platform\Assignment\Service;

use Streams\Platform\Assignment\Command\UnassignFieldCommand;
use Streams\Platform\Field\FieldModel;
use Laracasts\Commander\CommanderTrait;
use Streams\Platform\Stream\StreamModel;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Assignment\Command\AssignFieldCommand;

class AssignmentManagerService
{
    use CommanderTrait;

    /**
     * Assign a field to a stream.
     *
     * @param AddonAbstract $addon
     * @param StreamModel    $stream
     * @param FieldModel     $field
     * @param array          $assignment
     * @return mixed
     */
    public function assign(
        AddonAbstract $addon,
        StreamModel $stream,
        FieldModel $field,
        array $assignment
    ) {
        // Determine sort order
        $sortOrder = evaluate_key($assignment, 'sort_order', false, [$addon]);

        // Determine the stream ID and field ID.
        $streamId = $stream->getKey();
        $fieldId  = $field->getKey();

        // Create some merge data for the strings to follow.
        $mergeData = ['slug' => $stream->slug, 'namespace' => $stream->namespace, 'type' => $addon->getType()];

        // Determine assignment name and instructions.
        $name         = merge(app('config')->get('streams.field.name'), $mergeData);
        $instructions = merge(app('config')->get('streams.field.instructions'), $mergeData);

        $name         = evaluate_key($assignment, 'name', $name, [$addon]);
        $instructions = evaluate_key($assignment, 'description', $instructions, [$addon]);

        // Determine the rest of the assignment properties.
        $isRequired     = evaluate_key($assignment, 'is_required', false, [$addon]);
        $isUnique       = evaluate_key($assignment, 'is_unique', false, [$addon]);
        $isTranslatable = evaluate_key($assignment, 'is_translatable', false, [$addon]);
        $isRevisionable = evaluate_key($assignment, 'is_revisionable', false, [$addon]);

        $command = new AssignFieldCommand(
            $sortOrder,
            $streamId,
            $fieldId,
            $name,
            $instructions,
            $isRequired,
            $isUnique,
            $isTranslatable,
            $isRevisionable
        );

        return $this->execute($command);
    }

    /**
     * Unassign a field from a stream.
     *
     * @param $namespace
     * @param $stream
     * @param $slug
     * @return mixed
     */
    public function unassign($namespace, $stream, $slug)
    {
        $command = new UnassignFieldCommand($namespace, $stream, $slug);

        return $this->execute($command);
    }
}

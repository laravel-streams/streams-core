<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Assignment\Command\UpdateAssignmentColumn;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class UpdateFieldAssignments
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class UpdateFieldAssignments implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The field instance.
     *
     * @var FieldInterface
     */
    protected $field;

    /**
     * Create a new UpdateFieldAssignments instance.
     *
     * @param FieldInterface $field
     */
    public function __construct(FieldInterface $field)
    {
        $this->field = $field;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        foreach ($this->field->getAssignments() as $assignment) {
            $this->dispatch(new UpdateAssignmentColumn($assignment->setRelation('field', $this->field)));
        }
    }
}

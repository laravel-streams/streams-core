<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class DeleteAssignmentTranslations
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Command
 */
class DeleteAssignmentTranslations implements SelfHandling
{

    /**
     * The assignment interface.
     *
     * @var AssignmentInterface
     */
    protected $assignment;

    /**
     * Create a new AddAssignmentColumn instance.
     *
     * @param AssignmentInterface $assignment
     */
    public function __construct(AssignmentInterface $assignment)
    {
        $this->assignment = $assignment;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        foreach ($this->assignment->getTranslations() as $translation) {
            $translation->delete();
        }
    }

}

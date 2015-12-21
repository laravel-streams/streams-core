<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class CleanupStreams
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class CleanupStreams implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param AssignmentRepositoryInterface $assignments
     * @param StreamRepositoryInterface     $streams
     * @param FieldRepositoryInterface      $fields
     */
    public function handle(
        AssignmentRepositoryInterface $assignments,
        StreamRepositoryInterface $streams,
        FieldRepositoryInterface $fields
    ) {
        $assignments->cleanup();
        $streams->cleanup();
        $fields->cleanup();
    }
}

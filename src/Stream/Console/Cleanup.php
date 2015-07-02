<?php namespace Anomaly\Streams\Platform\Stream\Console;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Console\Command;

/**
 * Class Cleanup
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Console
 */
class Cleanup extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'streams:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup streams entry models.';

    /**
     * Execute the console command.
     *
     * @param FieldRepositoryInterface      $fields
     * @param StreamRepositoryInterface     $streams
     * @param AssignmentRepositoryInterface $assignments
     */
    public function fire(
        FieldRepositoryInterface $fields,
        StreamRepositoryInterface $streams,
        AssignmentRepositoryInterface $assignments
    ) {
        $streams->deleteGarbage();
        $this->info('Abandoned streams deleted successfully.');

        $fields->deleteGarbage();
        $this->info('Abandoned fields deleted successfully.');

        $assignments->deleteGarbage();
        $this->info('Abandoned assignments deleted successfully.');
    }
}

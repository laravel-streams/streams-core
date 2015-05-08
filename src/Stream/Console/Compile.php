<?php namespace Anomaly\Streams\Platform\Stream\Console;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Console\Command;

/**
 * Class Compile
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Console
 */
class Compile extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'streams:compile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile streams entry models.';

    /**
     * Execute the console command.
     *
     * @param StreamRepositoryInterface $streams
     */
    public function fire(StreamRepositoryInterface $streams)
    {
        /* @var StreamInterface $stream */
        foreach ($streams->all() as $stream) {
            if ($streams->save($stream)) {
                $this->info($stream->getEntryModelName() . ' compiled successfully.');
            }
        }
    }
}

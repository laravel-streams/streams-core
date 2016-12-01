<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Anomaly\Streams\Platform\Search\Command\CheckEntryIndex;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class CreateEntrySearchIndexes
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateEntrySearchIndexes
{

    use DispatchesJobs;

    /**
     * Handle the command.
     *
     * @param StreamRepositoryInterface $streams
     */
    public function handle(StreamRepositoryInterface $streams)
    {
        /* @var StreamInterface $stream */
        foreach ($streams->findAllBySearchable(true) as $stream) {
            $this->dispatch(new CheckEntryIndex($stream));
        }
    }
}

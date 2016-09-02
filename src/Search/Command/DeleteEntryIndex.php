<?php namespace Anomaly\Streams\Platform\Search\Command;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Laravel\Scout\EngineManager;

class DeleteEntryIndex
{
    /**
     * The stream instance.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new CheckCreateIndex instance.
     *
     * @param StreamInterface $stream [description]
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Handle the command.
     *
     * @param Application $application
     */
    public function handle(Application $application, Filesystem $files)
    {
        if (!class_exists('TeamTNT\TNTSearch\TNTSearch')) {
            return;
        }

        $model = $this->stream->getEntryModel();

        $index = $application->getStoragePath('search/' . $model->searchableAs() . '.index');

        if (!file_exists($index)) {
            return;
        }

        $files->delete($index);
    }
}

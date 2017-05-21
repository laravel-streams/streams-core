<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Support\Parser;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GenerateEntryModel
{
    use DispatchesJobs;

    /**
     * The stream interface.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new GenerateEntryModel instance.
     *
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Handle the command.
     *
     * @param Filesystem  $files
     * @param Parser      $parser
     * @param Application $application
     */
    public function handle(Filesystem $files, Parser $parser, Application $application, Dispatcher $events)
    {
        $config = $this->dispatch(new GetConfiguration($this->stream));

        $events->fire('entry.generating', [$this->stream, $config]);

        $template = file_get_contents($config->get('templatePath'));

        $path = $application->getStoragePath('models/' . studly_case($this->stream->getNamespace()));

        $files->makeDirectory($path, 0777, true, true);

        $file = $path . '/' . studly_case($this->stream->getNamespace()) . studly_case($this->stream->getSlug()) . 'EntryModel.php';

        $files->makeDirectory(dirname($file), 0777, true, true);
        $files->delete($file);

        $files->put($file, $parser->parse($template, $config->get('data')));
    }
}

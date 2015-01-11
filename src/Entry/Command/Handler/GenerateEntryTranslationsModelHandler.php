<?php namespace Anomaly\Streams\Platform\Entry\Command\Handler;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Entry\Command\GenerateEntryTranslationsModel;
use Anomaly\Streams\Platform\Entry\Parser\EntryNamespaceParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationsClassParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationsTableParser;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class GenerateEntryTranslationsModelHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry\Command
 */
class GenerateEntryTranslationsModelHandler
{

    /**
     * The streams application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new GenerateEntryTranslationsModelHandler instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Handle the command.
     *
     * @param GenerateEntryTranslationsModel $command
     */
    public function handle(GenerateEntryTranslationsModel $command)
    {
        $stream = $command->getStream();

        $data = $this->getTemplateData($stream);

        $template = file_get_contents(app('streams.path') . '/resources/assets/generator/translation.twig');

        $file = $this->getFilePath($stream);

        @unlink($file);

        file_put_contents($file, app('twig.string')->render($template, $data));
    }

    /**
     * Get the compiled entry model path for a stream.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected function getFilePath(StreamInterface $stream)
    {
        $path = storage_path('models/streams/' . $this->application->getReference() . '/');

        $path .= studly_case($stream->getNamespace()) . '/';

        $path .= studly_case($stream->getNamespace()) . studly_case($stream->getSlug());

        return $path . 'EntryTranslationsModel.php';
    }

    /**
     * Get the template data from a stream object.
     *
     * @param  StreamInterface $stream
     * @return array
     */
    protected function getTemplateData(StreamInterface $stream)
    {
        return [
            'namespace' => (new EntryNamespaceParser())->parse($stream),
            'class'     => (new EntryTranslationsClassParser())->parse($stream),
            'table'     => (new EntryTranslationsTableParser())->parse($stream),
        ];
    }
}

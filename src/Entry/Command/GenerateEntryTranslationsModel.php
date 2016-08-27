<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

class GenerateEntryTranslationsModel
{

    /**
     * The stream interface.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new GenerateEntryTranslationsModel instance.
     *
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Create a new GenerateEntryTranslationsModelHandler instance.
     *
     * @param Parser      $parser
     * @param Application $application
     */
    public function __construct(Parser $parser, Application $application)
    {
        $this->parser      = $parser;
        $this->application = $application;
    }

    /**
     * Handle the command.
     *
     * @param GenerateEntryTranslationsModel $command
     */
    public function handle(GenerateEntryTranslationsModel $command)
    {
        $data = [
            'namespace' => (new EntryNamespaceParser())->parse($this->stream),
            'class'     => (new EntryTranslationsClassParser())->parse($this->stream),
            'table'     => (new EntryTranslationsTableParser())->parse($this->stream),
        ];

        $template = file_get_contents(__DIR__ . '/../../../resources/stubs/models/translation.stub');

        $path = $this->application->getStoragePath('models/' . studly_case($this->stream->getNamespace()));

        $path .= '/' . studly_case($this->stream->getNamespace()) . studly_case($this->stream->getSlug());

        $file = $path . 'EntryTranslationsModel.php';

        @unlink($file); // Don't judge me..

        file_put_contents($file, $this->parser->parse($template, $data));
    }
}

<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\Parser\EntryNamespaceParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationsClassParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationsTableParser;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Way\Generators\Generator;

/**
 * Class GenerateEntryTranslationsModelCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry\Command
 */
class GenerateEntryTranslationsModelCommandHandler
{

    /**
     * The generator object.
     *
     * @var \Way\Generators\Generator
     */
    protected $generator;

    /**
     * Create a new GenerateEntryTranslationsModelCommandHandler instance.
     *
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Handle the command.
     *
     * @param GenerateEntryTranslationsModelCommand $command
     */
    public function handle(GenerateEntryTranslationsModelCommand $command)
    {
        $stream = $command->getStream();

        $data = $this->getTemplateData($stream);

        $template = app('streams.path') . '/resources/assets/generator/translation.txt';

        $file = $this->getFilePath($stream);

        @unlink($file);

        $this->generator->make($template, $data, $file);
    }

    /**
     * Get the compiled entry model path for a stream.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected function getFilePath(StreamInterface $stream)
    {
        $path = storage_path('models/streams/' . app('streams.application')->getReference() . '/');

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

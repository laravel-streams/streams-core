<?php namespace Anomaly\Streams\Platform\Entry\Command\Handler;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Entry\Command\GenerateEntryModel;
use Anomaly\Streams\Platform\Entry\Parser\EntryClassParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryDatesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryFieldSlugsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryNamespaceParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRelationsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRulesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryStreamParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTableParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTitleParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslatedAttributesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationForeignKeyParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationModelParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTrashableParser;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Support\Parser;
use Illuminate\Filesystem\Filesystem;

/**
 * Class GenerateEntryModelHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry\Command
 */
class GenerateEntryModelHandler
{

    /**
     * The file system utility.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The parser utility.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new GenerateEntryModelHandler instance.
     *
     * @param Filesystem  $files
     * @param Parser      $parser
     * @param Application $application
     */
    function __construct(Filesystem $files, Parser $parser, Application $application)
    {
        $this->files       = $files;
        $this->parser      = $parser;
        $this->application = $application;
    }

    /**
     * Handle the command.
     *
     * @param GenerateEntryModel $command
     */
    public function handle(GenerateEntryModel $command)
    {
        $stream = $command->getStream();

        $data = $this->getTemplateData($stream);

        $template = file_get_contents(__DIR__ . '/../../../../resources/stubs/models/entry.stub');

        $file = $this->getFilePath($stream);

        $this->files->makeDirectory(dirname($file), 0777, true, true);
        $this->files->delete($file);

        $this->files->put($file, $this->parser->parse($template, $data));
    }

    /**
     * Get the destination path the compiled entry model.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected function getFilePath(StreamInterface $stream)
    {
        $path = $this->application->getStoragePath('models/' . studly_case($stream->getNamespace()));

        $this->files->makeDirectory($path, 0777, true, true);

        return $path . '/' . studly_case($stream->getNamespace()) . studly_case($stream->getSlug()) . 'EntryModel.php';
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
            'class'                   => (new EntryClassParser())->parse($stream),
            'title'                   => (new EntryTitleParser())->parse($stream),
            'table'                   => (new EntryTableParser())->parse($stream),
            'rules'                   => (new EntryRulesParser())->parse($stream),
            'dates'                   => (new EntryDatesParser())->parse($stream),
            'stream'                  => (new EntryStreamParser())->parse($stream),
            'trashable'               => (new EntryTrashableParser())->parse($stream),
            'relations'               => (new EntryRelationsParser())->parse($stream),
            'namespace'               => (new EntryNamespaceParser())->parse($stream),
            'field_slugs'             => (new EntryFieldSlugsParser())->parse($stream),
            'translation_model'       => (new EntryTranslationModelParser())->parse($stream),
            'translated_attributes'   => (new EntryTranslatedAttributesParser())->parse($stream),
            'translation_foreign_key' => (new EntryTranslationForeignKeyParser())->parse($stream)
        ];
    }
}

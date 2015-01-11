<?php namespace Anomaly\Streams\Platform\Entry\Command\Handler;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Entry\Command\GenerateEntryModel;
use Anomaly\Streams\Platform\Entry\Parser\EntryClassParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryDatesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryInterfacesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryNamespaceParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRelationsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRulesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryStreamParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTableParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTitleParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTraitsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationForeignKeyParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationModelParser;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

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
     * The streams application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new GenerateEntryModelHandler instance.
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
     * @param GenerateEntryModel $command
     */
    public function handle(GenerateEntryModel $command)
    {
        $stream = $command->getStream();

        $data = $this->getTemplateData($stream);

        $template = file_get_contents(app('streams.path') . '/resources/assets/generator/model.twig');

        $file = $this->getFilePath($stream);

        @mkdir(dirname($file), 777, true);
        @unlink($file);

        file_put_contents($file, app('twig.string')->render($template, $data));
    }

    /**
     * Get the destination path the compiled entry model.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected function getFilePath(StreamInterface $stream)
    {
        $path = storage_path('models/streams/');

        @mkdir($path, 0755);
        @mkdir($path .= $this->application->getReference() . '/', 0755);
        @mkdir($path .= studly_case($stream->getNamespace()) . '/', 0755);

        return $path . studly_case($stream->getNamespace()) . studly_case($stream->getSlug()) . 'EntryModel.php';
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
            'traits'                  => (new EntryTraitsParser())->parse($stream),
            'relations'               => (new EntryRelationsParser())->parse($stream),
            'namespace'               => (new EntryNamespaceParser())->parse($stream),
            'interfaces'              => (new EntryInterfacesParser())->parse($stream),
            'translation_model'       => (new EntryTranslationModelParser())->parse($stream),
            'translation_foreign_key' => (new EntryTranslationForeignKeyParser())->parse($stream)
        ];
    }
}

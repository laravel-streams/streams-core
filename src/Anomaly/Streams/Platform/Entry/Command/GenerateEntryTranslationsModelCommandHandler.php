<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\EntryTranslationsGenerator;

class GenerateEntryTranslationsModelCommandHandler
{

    protected $generator;

    function __construct(EntryTranslationsGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function handle(GenerateEntryTranslationsModelCommand $command)
    {
        $template = file_get_contents(streams_path('resources/assets/generator/translation.txt'));

        $data = $command->getStream();

        $path = $this->getPath($data);

        $this->generator->make($template, $data, $path);
    }

    protected function getPath($stream)
    {
        $path = storage_path('models/streams/' . APP_REF . '/');

        $path .= studly_case($stream->namespace) . '/';

        return $path . studly_case($stream->namespace) . studly_case($stream->slug) . 'EntryTranslationsModel.php';
    }
}
 
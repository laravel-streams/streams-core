<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\EntryGenerator;

class GenerateEntryModelCommandHandler
{
    protected $generator;

    function __construct(EntryGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function handle(GenerateEntryModelCommand $command)
    {
        $template = file_get_contents(streams_path('resources/assets/generator/model.txt'));

        $data = $command->getStream();

        $path = $this->getPath($data);

        $this->generator->make($template, $data, $path);
    }

    protected function getPath($stream)
    {
        $path = storage_path('models/streams/');

        $path .= $namespace = studly_case($stream->namespace) . '/';

        return $path . $namespace . studly_case($stream->slug) . 'EntryModel.php';
    }
}
 
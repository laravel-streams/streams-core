<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\EntryTranslationsGenerator;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class GenerateEntryTranslationsModelCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Command
 */
class GenerateEntryTranslationsModelCommandHandler
{

    /**
     * Handle the command.
     *
     * @param GenerateEntryTranslationsModelCommand $command
     * @param EntryTranslationsGenerator            $generator
     */
    public function handle(GenerateEntryTranslationsModelCommand $command, EntryTranslationsGenerator $generator)
    {
        $stream = $command->getStream();

        $path = $this->getPath($stream);

        $template = file_get_contents(streams_path('resources/assets/generator/translation.txt'));

        $generator->make($template, $stream, $path);
    }

    /**
     * Get the compiled entry model path for a stream.
     *
     * @param StreamInterface $stream
     * @return string
     */
    protected function getPath(StreamInterface $stream)
    {
        $path = storage_path('models/streams/' . APP_REF . '/');

        $path .= studly_case($stream->getNamespace()) . '/';

        $path .= studly_case($stream->getNamespace()) . studly_case($stream->getSlug());

        return $path . 'EntryTranslationsModel.php';
    }
}
 
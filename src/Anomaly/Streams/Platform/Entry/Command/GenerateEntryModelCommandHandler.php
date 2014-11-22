<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\EntryGenerator;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class GenerateEntryModelCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Command
 */
class GenerateEntryModelCommandHandler
{

    /**
     * Handle the command.
     *
     * @param GenerateEntryModelCommand $command
     */
    public function handle(GenerateEntryModelCommand $command, EntryGenerator $generator)
    {
        $stream = $command->getStream();

        $path = $this->getPath($stream);

        $template = file_get_contents(streams_path('resources/assets/generator/model.txt'));

        $generator->make($template, $stream, $path);
    }

    /**
     * Get the destination path the compiled entry model.
     *
     * @param StreamInterface $stream
     * @return string
     */
    protected function getPath(StreamInterface $stream)
    {
        $path = storage_path('models/streams/' . APP_REF . '/');

        $path .= studly_case($stream->getNamespace()) . '/';

        return $path . studly_case($stream->getNamespace()) . studly_case($stream->getSlug()) . 'EntryModel.php';
    }
}
 
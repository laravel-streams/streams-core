<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class DeleteStreamTranslations
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Command
 */
class DeleteStreamTranslations implements SelfHandling
{

    /**
     * The stream instance.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new DeleteStreamTranslations instance.
     *
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        foreach ($this->stream->getTranslations() as $translation) {
            $translation->delete();
        }
    }
}

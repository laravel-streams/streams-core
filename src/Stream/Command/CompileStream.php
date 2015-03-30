<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Entry\EntryUtility;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class CompileStream
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Command
 */
class CompileStream implements SelfHandling
{

    /**
     * The stream interface.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new CompileStream instance.
     *
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Handle the command.
     *
     * @param EntryUtility $utility
     */
    public function handle(EntryUtility $utility)
    {
        $utility->recompile($this->stream);
    }
}

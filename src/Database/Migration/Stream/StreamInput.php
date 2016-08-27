<?php namespace Anomaly\Streams\Platform\Database\Migration\Stream;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Database\Migration\Stream\StreamGuesser;
use Anomaly\Streams\Platform\Database\Migration\Stream\StreamNormalizer;
use Illuminate\Contracts\Config\Repository;

class StreamInput
{

    /**
     * The stream guesser.
     *
     * @var StreamGuesser
     */
    protected $guesser;

    /**
     * The stream normalizer.
     *
     * @var StreamNormalizer
     */
    protected $normalizer;

    /**
     * Create a new StreamInput instance.
     *
     * @param StreamGuesser    $guesser
     * @param StreamNormalizer $normalizer
     */
    public function __construct(StreamGuesser $guesser, StreamNormalizer $normalizer)
    {
        $this->guesser    = $guesser;
        $this->normalizer = $normalizer;
    }

    /**
     * Read the streams input.
     *
     * @param Migration $migration
     */
    public function read(Migration $migration)
    {
        if (!$migration->getStream()) {
            return;
        }
        
        $this->normalizer->normalize($migration);
        $this->guesser->guess($migration);
    }
}

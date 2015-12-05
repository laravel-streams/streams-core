<?php namespace Anomaly\Streams\Platform\Entry\Plugin\Command;

use Anomaly\Streams\Platform\Entry\Plugin\EntryQuery;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class GetEntryBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Plugin\Command
 */
class GetEntryBuilder implements SelfHandling
{

    /**
     * The getter method.
     *
     * @var string
     */
    protected $method;

    /**
     * The stream slug.
     *
     * @var string
     */
    protected $stream;

    /**
     * The stream namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Create a new GetEntryBuilder instance.
     *
     * @param $namespace
     * @param $stream
     */
    public function __construct($namespace, $stream, $method = 'get')
    {
        $this->method    = $method;
        $this->stream    = $stream;
        $this->namespace = $namespace;
    }

    /**
     * Handle the command.
     *
     * @param EntryQuery $query
     * @return \Anomaly\Streams\Platform\Entry\Plugin\EntryBuilder
     */
    public function handle(EntryQuery $query)
    {
        return $query->make($this->namespace, $this->stream, $this->method);
    }
}

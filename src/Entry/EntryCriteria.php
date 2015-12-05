<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Model\EloquentCriteria;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EntryCriteria
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Plugin
 */
class EntryCriteria extends EloquentCriteria
{

    /**
     * The query builder.
     *
     * @var Builder
     */
    protected $query;

    /**
     * The stream instance.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Set the get method.
     *
     * @var string
     */
    protected $method;

    /**
     * Create a new EntryCriteria instance.
     *
     * @param Builder         $query
     * @param StreamInterface $stream
     */
    public function __construct(Builder $query, StreamInterface $stream, $method = 'get')
    {
        $this->stream = $stream;

        parent::__construct($query, $method);
    }
}

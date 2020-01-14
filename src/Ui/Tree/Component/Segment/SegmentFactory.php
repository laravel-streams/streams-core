<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Tree\Component\Segment\Contract\SegmentInterface;

/**
 * Class SegmentFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SegmentFactory
{

    /**
     * The default segment class.
     *
     * @var string
     */
    protected $segment = Segment::class;

    /**
     * Make a segment.
     *
     * @param  array            $parameters
     * @return SegmentInterface
     */
    public function make(array $parameters)
    {
        $segment = app()->make(array_get($parameters, 'segment', $this->segment), $parameters);

        Hydrator::hydrate($segment, $parameters);

        return $segment;
    }
}

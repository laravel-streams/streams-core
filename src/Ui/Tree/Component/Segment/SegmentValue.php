<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Anomaly\Streams\Platform\Support\Value;
use Anomaly\Streams\Platform\Ui\Tree\Tree;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\View\View;

/**
 * Class SegmentValue
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Segment
 */
class SegmentValue
{

    /**
     * The value resolver.
     *
     * @var Value
     */
    protected $value;

    /**
     * Create a new SegmentValue instance.
     *
     * @param Value $value
     */
    public function __construct(Value $value)
    {
        $this->value = $value;
    }

    /**
     * Return the segment value.
     *
     * @param Tree  $tree
     * @param array $segment
     * @param       $entry
     * @return View|mixed|null
     */
    public function make(Tree $tree, array $segment, $entry)
    {
        return $this->value->make($segment, $entry, 'entry', compact('tree'));
    }
}

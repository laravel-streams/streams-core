<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment\Command\Handler;

use Anomaly\Streams\Platform\Ui\Tree\Component\Segment\SegmentValue;
use Anomaly\Streams\Platform\Ui\Tree\Component\Segment\Command\GetSegmentValue;

/**
 * Class GetSegmentValueHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Segment\Command
 */
class GetSegmentValueHandler
{

    /**
     * The value utility.
     *
     * @var \Anomaly\Streams\Platform\Ui\Tree\Component\Segment\SegmentValue
     */
    protected $value;

    /**
     * Create a new GetSegmentValueHandler instance.
     *
     * @param SegmentValue $value
     */
    public function __construct(SegmentValue $value)
    {
        $this->value = $value;
    }

    /**
     * Handle the command.
     *
     * @param GetSegmentValue $command
     * @return mixed
     */
    public function handle(GetSegmentValue $command)
    {
        $entry  = $command->getEntry();
        $tree  = $command->getTree();
        $segment = $command->getSegment();

        return $this->value->make($tree, $segment, $entry);
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class SegmentBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SegmentBuilder
{

    /**
     * The segment reader.
     *
     * @var SegmentInput
     */
    protected $input;

    /**
     * The segment value.
     *
     * @var SegmentValue
     */
    protected $value;

    /**
     * The segment factory.
     *
     * @var SegmentFactory
     */
    protected $factory;

    /**
     * The evaluator utility.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * Create a new SegmentBuilder instance.
     *
     * @param SegmentInput   $input
     * @param SegmentValue   $value
     * @param SegmentFactory $factory
     * @param Evaluator      $evaluator
     */
    public function __construct(SegmentInput $input, SegmentValue $value, SegmentFactory $factory, Evaluator $evaluator)
    {
        $this->input     = $input;
        $this->value     = $value;
        $this->factory   = $factory;
        $this->evaluator = $evaluator;
    }

    /**
     * Build the segments.
     *
     * @param  TreeBuilder       $builder
     * @param                    $entry
     * @return SegmentCollection
     */
    public function build(TreeBuilder $builder, $entry)
    {
        $tree = $builder->getTree();

        $segments = new SegmentCollection();

        $this->input->read($builder);

        foreach ($builder->getSegments() as $segment) {
            array_set($segment, 'entry', $entry);

            $segment = $this->evaluator->evaluate($segment, compact('entry', 'tree'));

            if (array_get($segment, 'enabled', null) === false) {
                continue;
            }

            $segment['value'] = $this->value->make($tree, $segment, $entry);

            $segments->push($this->factory->make($segment));
        }

        return $segments;
    }
}

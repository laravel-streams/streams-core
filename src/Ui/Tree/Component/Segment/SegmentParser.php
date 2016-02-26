<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class SegmentParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Segment
 */
class SegmentParser
{

    /**
     * The parser utility.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * Create a new segment parser.
     *
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse the segments.
     *
     * @param TreeBuilder $builder
     */
    public function parse(TreeBuilder $builder)
    {
        $builder->setSegments($this->parser->parse($builder->getSegments()));
    }
}

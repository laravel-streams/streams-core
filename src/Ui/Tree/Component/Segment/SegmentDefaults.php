<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;

/**
 * Class SegmentDefaults
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SegmentDefaults
{

    /**
     * The section collection.
     *
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * Create a new SegmentDefaults instance.
     *
     * @param SectionCollection $builder
     */
    public function __construct(SectionCollection $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle default segments.
     *
     * @param TreeBuilder $builder
     */
    public function defaults(TreeBuilder $builder)
    {
        if ($builder->getSegments()) {
            return;
        }

        if (!$section = $this->builder->controlPanel->sections->active()) {
            return;
        }

        $builder->setSegments(
            [
                [
                    'wrapper' => '<a href="' . $section->getHref('edit') . '/{entry.id}">{value}</a>',
                    'value'   => 'entry.title',
                ],
            ]
        );
    }
}

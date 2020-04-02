<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Illuminate\Support\Facades\Lang;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class SegmentTranslator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SegmentTranslator
{

    /**
     * Translate the tree segments.
     *
     * @param TreeBuilder $builder
     */
    public function translate(TreeBuilder $builder)
    {
        $builder->setSegments(Lang::translate($builder->getSegments()));
    }
}

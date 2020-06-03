<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Support\Workflows\BuildWorkflow;

/**
 * Class ActionBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ActionBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'parent' => null,

        'assets' => [],

        'component' => 'action',

        'action' => Action::class,
        
        'build_workflow' => BuildWorkflow::class,
    ];
}

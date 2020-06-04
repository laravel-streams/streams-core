<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Support\Workflows\BuildWorkflow;

/**
 * Class ButtonBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'parent' => null,

        'assets' => [],

        'component' => 'button',

        'button' => Button::class,

        'build_workflow' => BuildWorkflow::class,
    ];
}

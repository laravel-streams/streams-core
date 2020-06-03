<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\MergeComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\Workflows\Buttons\DefaultButtons;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\Workflows\Buttons\NormalizeButtons;

/**
 * Class ButtonsWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonsWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        'resolve_buttons' => ResolveComponents::class,

        DefaultButtons::class,
        NormalizeButtons::class,

        'merge_buttons' => MergeComponents::class,

        'translate_buttons' => TranslateComponents::class,
        'parse_buttons' => ParseComponents::class,

        'build_buttons' => BuildComponents::class,
    ];
}

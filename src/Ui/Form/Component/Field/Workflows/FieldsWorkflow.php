<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Platform\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Workflows\Fields\DefaultFields;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Workflows\Fields\PopulateFields;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Workflows\Fields\NormalizeFields;

/**
 * Class FieldsWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldsWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        'resolve_fields' => ResolveComponents::class,

        DefaultFields::class,
        NormalizeFields::class,

        //'merge_fields' => MergeComponents::class,

        'translate_fields' => TranslateComponents::class,
        'parse_fields' => ParseComponents::class,

        'build_fields' => BuildComponents::class,
        
        'populate_fields' => PopulateFields::class,
    ];
}

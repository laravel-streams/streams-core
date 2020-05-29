<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Platform\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Platform\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Platform\Ui\Support\Workflows\MakeInstance;
use Anomaly\Streams\Platform\Ui\Support\Workflows\ResolveComponent;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows\Build\NormalizeComponent;

/**
 * Class BuildWorkflow
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [

        /**
         * Make dat instance.
         */
        MakeInstance::class,

        /**
         * Integrate with others.
         */
        LoadAssets::class,

        /**
         * Set important things.
         */
        SetStream::class,
        SetOptions::class,

        /**
         * Process input.
         */
        ResolveComponent::class,
        NormalizeComponent::class,
    ];
}

//$factory = app(ColumnFactory::class);

//$columns = new ColumnCollection();

// (new ColumnProcessor([
//     'parent' => $builder
// ]));

// dd($builder);

// ColumnInput::read($builder);

// foreach ($builder->columns as $column) {

//     array_set($column, 'entry', $entry);

//     $column = evaluate($column, compact('entry', 'builder'));

//     $column['value'] = valuate($column, $entry);

//     $columns->push($factory->make(translate($column)));
// }

// return $columns;

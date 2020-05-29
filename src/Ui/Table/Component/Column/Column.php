<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Ui\Support\Component;

/**
 * Class Column
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Column extends Component
{

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct(array_merge([
            'component' => 'column',

            'view' => null,
            'value' => null,
            'entry' => null,
            'heading' => null,
            'wrapper' => null,
        ], $attributes));
    }
}

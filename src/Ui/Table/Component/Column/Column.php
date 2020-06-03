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
     * The button attributes.
     *
     * @var array
     */
    protected $attributes = [
        'view' => null,
        'value' => null,
        'entry' => null,
        'heading' => null,
        'wrapper' => null,
    ];
}

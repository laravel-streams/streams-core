<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Row;

use Anomaly\Streams\Platform\Ui\Support\Component;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Class Row
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Row extends Component
{

    /**
     * The object attributes.
     *
     * @var array
     */
    protected $attributes = [
        'key' => null,
        'entry' => null,
        'table' => null,
        'columns' => null, //Collection
        'buttons' => null, //Collection
    ];
}

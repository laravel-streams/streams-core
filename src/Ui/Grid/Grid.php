<?php

namespace Anomaly\Streams\Platform\Ui\Grid;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Support\Component;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Grid\Component\Item\ItemCollection;

/**
 * Class Grid
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Grid extends Component
{

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct(array_merge([
            'mode' => null,
            'entry' => null,
            'component' => 'grid',

            'values' => new Collection(),
            'options' => new Collection(),

            'buttons' => new ButtonCollection(),
            'items' => new ItemCollection(),
        ], $attributes));
    }
}

<?php

namespace Anomaly\Streams\Platform\Ui\Tree;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Support\Component;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Tree\Component\Item\ItemCollection;

/**
 * Class Tree
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Tree extends Component
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
            'component' => 'tree',

            'values' => new Collection(),
            'options' => new Collection(),

            'buttons' => new ButtonCollection(),
            'items' => new ItemCollection(),
        ], $attributes));
    }
}

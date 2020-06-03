<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Support\Component;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderCollection;

/**
 * Class Table
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Table extends Component
{

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct(array_merge([
            'component' => 'table',

            'rows' => new Collection(),
            'columns' => new Collection(),
            'buttons' => new Collection(),
            'options' => new Collection(),
            'entries' => new Collection(),

            'views' => new ViewCollection(),
            'actions' => new ActionCollection(),
            'filters' => new FilterCollection(),
            'headers' => new HeaderCollection(),
        ], $attributes));
    }
}

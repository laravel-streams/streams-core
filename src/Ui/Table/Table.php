<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Anomaly\Streams\Platform\Ui\Support\Component;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\RowCollection;
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

            'options' => new Collection(),
            'entries' => new Collection(),

            'rows' => new RowCollection(),
            'views' => new ViewCollection(),
            'actions' => new ActionCollection(),
            'filters' => new FilterCollection(),
            'headers' => new HeaderCollection(),
        ], $attributes));
    }
}

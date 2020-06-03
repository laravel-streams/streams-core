<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Support\Component;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query\GenericFilterQuery;

/**
 * Class Filter
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Filter extends Component
{

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $attributes = [
        'slug' => null,
        'field' => null,
        'stream' => null,
        'prefix' => null,
        'column' => null,

        'placeholder' => null,

        'active' => false,
        'exact' => false,

        'query' => GenericFilterQuery::class,
    ];

    /**
     * Get the filter input.
     *
     * @return null|string
     */
    public function getInput()
    {
        return null;
    }

    /**
     * Get the filter value.
     *
     * @return null|string
     */
    public function getValue()
    {
        return app('request')->get($this->getInputName());
    }

    /**
     * Get the filter name.
     *
     * @return string
     */
    public function getInputName()
    {
        return $this->prefix . 'filter_' . $this->slug;
    }
}

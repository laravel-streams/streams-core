<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterRepositoryInterface;

class FilterRepository implements FilterRepositoryInterface
{

    protected $filters = [
        'input' => [
            'slug'   => 'input',
            'filter' => 'Anomaly\Streams\Platform\Ui\Table\Filter\Type\InputFilter',
        ]
    ];

    public function find($filter)
    {
        return array_get($this->filters, $filter);
    }
}
 
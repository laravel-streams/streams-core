<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query\FieldFilterQuery;

/**
 * Class FieldFilter
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldFilter extends Filter
{

    /**
     * The filter query.
     *
     * @var string
     */
    protected $query = FieldFilterQuery::class;

    /**
     * Get the input HTML.
     *
     * @return \Illuminate\View\View
     */
    public function getInput()
    {
        if (!$field = $this->stream->fields->get($this->field)) {
            return;
        }

        $type = $field->type();

        $type->setLocale(null);
        $type->setValue($this->getValue());
        $type->setPrefix($this->prefix . 'filter_');
        $type->setAttribute('placeholder', $this->placeholder);

        return $type->getFilter();
    }
}

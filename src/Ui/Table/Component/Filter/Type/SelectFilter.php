<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\SelectFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;

/**
 * Class SelectFilter
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SelectFilter extends Filter implements SelectFilterInterface
{

    /**
     * The field type builder.
     *
     * @var FieldTypeBuilder
     */
    protected $builder;

    /**
     * The filter options.
     *
     * @var array
     */
    protected $options;

    /**
     * Create a new SelectFilter instance.
     *
     * @param FieldTypeBuilder $builder
     */
    public function __construct(FieldTypeBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get the input HTML.
     *
     * @return string
     */
    public function getInput()
    {
        resolver($this->getOptions(), ['filter' => $this]);

        return $this->builder->build(['type' => 'anomaly.field_type.select'])
            ->setPlaceholder($this->getPlaceholder())
            ->setField('filter_' . $this->getSlug())
            ->setAttributes($this->attributes())
            ->setPrefix($this->getPrefix())
            ->setValue($this->getValue())
            ->mergeConfig(
                [
                    'options' => evaluate($this->getOptions(), ['filter' => $this]),
                ]
            )->getFilter();
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the options.
     *
     * @param  array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }
}

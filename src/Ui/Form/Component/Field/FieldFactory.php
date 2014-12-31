<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeBuilder;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class FieldFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldFactory
{

    /**
     * The field type builder utility.
     *
     * @var \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeBuilder
     */
    protected $builder;

    /**
     * Create a new FieldFactory instance.
     *
     * @param FieldTypeBuilder $builder
     */
    public function __construct(FieldTypeBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Make a field type.
     *
     * @param array           $parameters
     * @param StreamInterface $stream
     * @param null            $entry
     * @return \Anomaly\Streams\Platform\Addon\FieldType\FieldType|mixed
     */
    public function make(array $parameters, StreamInterface $stream = null, $entry = null)
    {
        if ($stream->getField($parameters['field'])) {
            $field = $stream->getFieldType($parameters['field'], $entry);
        } else {
            $field = $this->builder->build($parameters);
        }

        return $field;
    }
}

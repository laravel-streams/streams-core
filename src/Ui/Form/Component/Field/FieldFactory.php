<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeBuilder;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Http\Request;

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
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new FieldFactory instance.
     *
     * @param FieldTypeBuilder $builder
     * @param Request          $request
     */
    public function __construct(FieldTypeBuilder $builder, Request $request)
    {
        $this->builder = $builder;
        $this->request = $request;
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
        if ($stream && $assignment = $stream->getAssignment($parameters['field'])) {
            $field = $assignment->getFieldType($entry);
        } else {
            $field = $this->builder->build($parameters);
        }

        // Set the value if the entry is compatible and the value is not forced.
        if (!isset($parameters['value']) && $entry instanceof EntryInterface) {
            $field->setValue($entry->getFieldValue($field->getField()));
        } else {
            $field->setValue(array_get($parameters, 'value'));
        }

        // Merge in rules and validators.
        $field->mergeRules(array_get($parameters, 'rules', []));
        $field->setDisabled(array_get($parameters, 'disabled', false));
        $field->mergeValidators(array_get($parameters, 'validators', []));

        return $field;
    }
}

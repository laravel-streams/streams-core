<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
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
     * @var FieldTypeBuilder
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
     * @return FieldType
     */
    public function make(array $parameters, StreamInterface $stream = null, $entry = null)
    {
        if ($stream && $assignment = $stream->getAssignment(array_get($parameters, 'field'))) {

            $field = $assignment->getFieldType();

            /* @var EntryInterface $entry */
            $field->setValue(array_pull($parameters, 'value', $entry->getFieldValue($field->getField())));
        } elseif (is_object($entry)) {

            $field = $this->builder->build($parameters);

            $field->setValue(array_pull($parameters, 'value', $entry->{$field->getField()}));
        } else {

            $field = $this->builder->build($parameters);

            $field->setValue(array_pull($parameters, 'value'));
        }

        // Set the entry.
        $field->setEntry($entry);

        // Merge in rules and validators.
        $field->mergeRules(array_pull($parameters, 'rules', []));
        $field->mergeConfig(array_pull($parameters, 'config', []));
        $field->mergeValidators(array_pull($parameters, 'validators', []));

        // Hydrate the field with parameters.
        $this->hydrate($field, $parameters);

        return $field;
    }

    /**
     * Hydrate the field type object with the parameters.
     *
     * @param FieldType $fieldType
     * @param array     $parameters
     */
    protected function hydrate(FieldType $fieldType, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($fieldType, $method)) {
                $fieldType->{$method}($value);
            }
        }
    }
}

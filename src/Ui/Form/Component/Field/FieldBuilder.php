<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class FieldTypeBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldBuilder
{

    use CommanderTrait;

    /**
     * The field reader.
     *
     * @var FieldReader
     */
    protected $reader;

    /**
     * The field type builder.
     *
     * @var FieldTypeBuilder
     */
    protected $builder;

    /**
     * Create a new FieldTypeBuilder instance.
     *
     * @param FieldReader      $reader
     * @param FieldTypeBuilder $builder
     */
    public function __construct(FieldReader $reader, FieldTypeBuilder $builder)
    {
        $this->reader  = $reader;
        $this->builder = $builder;
    }

    /**
     * Build the fields.
     *
     * @param FormBuilder $builder
     */
    public function build(FormBuilder $builder)
    {
        $form   = $builder->getForm();
        $fields = $form->getFields();
        $stream = $form->getStream();
        $entry  = $form->getEntry();

        foreach ($builder->getFields() as $slug => $field) {

            $field = $this->reader->standardize($slug, $field);

            /**
             * If the field is a field type then
             * use the form's stream to resolve it.
             *
             * Otherwise build a generic field type
             * using the command.
             */
            $parameters = $field;

            if ($stream->getField($field['field'])) {
                $field = $stream->getFieldType($field['field'], $entry);

                foreach ($parameters as $parameter => $value) {

                    $method = camel_case('set_' . $parameter);

                    if (method_exists($field, $method)) {
                        $field->{$method}($value);
                    }
                }
            } else {
                $field = $this->builder->build($field);
            }

            $fields->put($field->getField(), $field);
        }
    }
}

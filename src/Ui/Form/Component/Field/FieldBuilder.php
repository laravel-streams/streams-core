<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeBuilder;
use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

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

    /**
     * The field reader.
     *
     * @var FieldInput
     */
    protected $input;

    /**
     * The field type builder.
     *
     * @var FieldTypeBuilder
     */
    protected $builder;

    /**
     * The field factory.
     *
     * @var FieldFactory
     */
    protected $factory;

    /**
     * The evaluator utility.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * Create a new FieldTypeBuilder instance.
     *
     * @param FieldInput   $input
     * @param FieldFactory $factory
     */
    public function __construct(FieldInput $input, FieldFactory $factory)
    {
        $this->input   = $input;
        $this->factory = $factory;
    }

    /**
     * Build the fields.
     *
     * @param FormBuilder $builder
     */
    public function build(FormBuilder $builder)
    {
        $form   = $builder->getForm();
        $skips  = $builder->getSkips();
        $stream = $form->getStream();
        $entry  = $form->getEntry();

        $this->input->read($builder);

        /**
         * Convert each field to a field object
         * and put to the forms field collection.
         */
        foreach ($builder->getFields() as $slug => $field) {
            if (!in_array($field['slug'], $skips) && array_get($field, 'enabled', true)) {
                $form->addField($this->factory->make($field, $stream, $entry));
            }
        }
    }
}

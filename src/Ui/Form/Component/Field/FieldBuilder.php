<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class FieldBuilder
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
     * The field factory.
     *
     * @var FieldFactory
     */
    protected $factory;

    /**
     * Create a new FieldBuilder instance.
     *
     * @param FieldReader  $reader
     * @param FieldFactory $factory
     */
    public function __construct(FieldReader $reader, FieldFactory $factory)
    {
        $this->reader  = $reader;
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
        $fields = $form->getFields();

        foreach ($builder->getFields() as $slug => $field) {

            $field = $this->reader->standardize($slug, $field);
            $field = $this->factory->make($field);

            $fields->put($field->getSlug(), $field);
        }
    }
}

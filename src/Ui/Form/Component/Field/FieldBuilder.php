<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeBuilder;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\FillGuesser;
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
     * The field factory.
     *
     * @var FieldFactory
     */
    protected $factory;

    /**
     * The fill guesser.
     *
     * @var FillGuesser
     */
    protected $fillGuesser;

    /**
     * The configurator utility.
     *
     * @var FieldConfigurator
     */
    protected $configurator;

    /**
     * Create a new FieldTypeBuilder instance.
     *
     * @param FieldReader       $reader
     * @param FieldFactory      $factory
     * @param FillGuesser       $fillGuesser
     * @param FieldConfigurator $configurator
     */
    public function __construct(
        FieldReader $reader,
        FieldFactory $factory,
        FillGuesser $fillGuesser,
        FieldConfigurator $configurator
    ) {
        $this->reader       = $reader;
        $this->factory      = $factory;
        $this->fillGuesser  = $fillGuesser;
        $this->configurator = $configurator;
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

        $configuration = $builder->getFields();

        /**
         * Start by standardizing the input.
         */
        foreach ($configuration as $key => &$parameters) {
            $parameters = $this->reader->standardize($key, $parameters);
        }

        /**
         * Guess the filler fields for "*".
         */
        if ($stream instanceof StreamInterface) {
            $configuration = $this->fillGuesser->guess($stream, $configuration);
        }

        /**
         * Convert each field to a field object
         * and put to the forms field collection.
         */
        foreach ($configuration as $key => $parameters) {

            // Standardize the input.
            $parameters = $this->reader->standardize($key, $parameters);

            // Make the field object.
            $field = $this->factory->make($parameters, $stream, $entry);

            // Configure the overrides using the configurator.
            $this->configurator->configure($field, $parameters);

            // Load it up onto the table's fields.
            $fields->put($field->getField(), $field);
        }
    }
}

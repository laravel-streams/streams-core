<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\FieldsGuesser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldGuesser
{

    /**
     * The fields guesser.
     *
     * @var FieldsGuesser
     */
    protected $fields;

    /**
     * Create a new FieldGuesser instance.
     *
     * @param FieldsGuesser $fields
     */
    public function __construct(FieldsGuesser $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Guess field input.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $this->fields->guess($builder);
    }
}

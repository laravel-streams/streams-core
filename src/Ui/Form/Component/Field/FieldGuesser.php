<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\InstructionsGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\LabelsGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\PlaceholdersGuesser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class HeadingGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldGuesser
{

    /**
     * The labels guesser.
     *
     * @var LabelsGuesser
     */
    protected $labels;

    /**
     * The instructions guesser.
     *
     * @var InstructionsGuesser
     */
    protected $instructions;

    /**
     * The placeholders guesser.
     *
     * @var PlaceholdersGuesser
     */
    protected $placeholders;

    /**
     * Create a new HeadingGuesser instance.
     *
     * @param LabelsGuesser       $labels
     * @param InstructionsGuesser $instructions
     * @param PlaceholdersGuesser $placeholders
     */
    public function __construct(
        LabelsGuesser $labels,
        InstructionsGuesser $instructions,
        PlaceholdersGuesser $placeholders
    ) {
        $this->labels       = $labels;
        $this->instructions = $instructions;
        $this->placeholders = $placeholders;
    }

    /**
     * Guess field input.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $this->labels->guess($builder);
        $this->instructions->guess($builder);
        $this->placeholders->guess($builder);
    }
}

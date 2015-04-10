<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\InstructionsGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\LabelsGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\PlaceholdersGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\PrefixesGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\RequiredGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\TranslatableGuesser;
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
     * The prefixes guesser.
     *
     * @var PrefixesGuesser
     */
    protected $prefixes;

    /**
     * The required guesser.
     *
     * @var RequiredGuesser
     */
    protected $required;

    /**
     * The translatable guesser.
     *
     * @var TranslatableGuesser
     */
    protected $translatable;

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
     * @param PrefixesGuesser     $prefixes
     * @param RequiredGuesser     $required
     * @param TranslatableGuesser $translatable
     * @param InstructionsGuesser $instructions
     * @param PlaceholdersGuesser $placeholders
     */
    public function __construct(
        LabelsGuesser $labels,
        PrefixesGuesser $prefixes,
        RequiredGuesser $required,
        TranslatableGuesser $translatable,
        InstructionsGuesser $instructions,
        PlaceholdersGuesser $placeholders
    ) {
        $this->labels       = $labels;
        $this->prefixes     = $prefixes;
        $this->required     = $required;
        $this->translatable = $translatable;
        $this->instructions = $instructions;
        $this->placeholders = $placeholders;
    }

    /**
     * Guess field input.
     *
     * @param FormBuilder $builder
     */
    public
    function guess(
        FormBuilder $builder
    ) {
        $this->labels->guess($builder);
        $this->prefixes->guess($builder);
        $this->required->guess($builder);
        $this->translatable->guess($builder);
        $this->instructions->guess($builder);
        $this->placeholders->guess($builder);
}
}

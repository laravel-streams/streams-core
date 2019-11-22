<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

/**
 * Class ButtonInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonInput
{

    /**
     * The button lookup.
     *
     * @var ButtonLookup
     */
    protected $lookup;

    /**
     * The button guesser.
     *
     * @var ButtonGuesser
     */
    protected $guesser;

    /**
     * The button dropdown utility.
     *
     * @var ButtonDropdown
     */
    protected $dropdown;

    /**
     * The resolver utility.
     *
     * @var ButtonResolver
     */
    protected $resolver;

    /**
     * Create a new ButtonInput instance.
     *
     * @param ButtonLookup     $lookup
     * @param ButtonGuesser    $guesser
     * @param ButtonDropdown   $dropdown
     * @param ButtonResolver   $resolver
     */
    public function __construct(
        ButtonLookup $lookup,
        ButtonGuesser $guesser,
        ButtonDropdown $dropdown,
        ButtonResolver $resolver
    ) {
        $this->lookup     = $lookup;
        $this->guesser    = $guesser;
        $this->dropdown   = $dropdown;
        $this->resolver   = $resolver;
    }

    /**
     * Read builder button input.
     *
     * @param FormBuilder $builder
     */
    public function read(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();
        $entry = $builder->getFormEntry();

        /**
         * Resolve & Evaluate
         */
        $buttons = resolver($buttons, compact('builder', 'entry'));

        $buttons = $buttons ?: $builder->getButtons();

        $buttons = evaluate($buttons, compact('builder', 'entry'));

        /**
         * Default
         */
        if ($buttons === [] && request()->segment(1) == 'admin') {
            $buttons[] = 'cancel';
        }

        /**
         * Normalize
         */
        $buttons = Normalizer::start($buttons, 'button');
        $buttons = Normalizer::attributes($buttons);
        $buttons = Normalizer::dropdowns($buttons);

        $builder->setButtons($buttons);

        // UN-CONVERTED BELOW
        // -------------------------------
        $this->dropdown->flatten($builder);
        $this->lookup->merge($builder);
        $this->guesser->guess($builder);

        $builder->setButtons(parse($builder->getButtons(), compact('entry')));

        $this->dropdown->build($builder);
        // -------------------------------
    }
}

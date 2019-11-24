<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
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
     * Create a new ButtonInput instance.
     *
     * @param ButtonLookup     $lookup
     * @param ButtonGuesser    $guesser
     */
    public function __construct(
        ButtonLookup $lookup,
        ButtonGuesser $guesser
    ) {
        $this->lookup     = $lookup;
        $this->guesser    = $guesser;
    }

    /**
     * Read builder button input.
     *
     * @param  ControlPanelBuilder $builder
     * @return array
     */
    public function read(ControlPanelBuilder $builder)
    {
        $buttons = $builder->getButtons();

        /**
         * Resolve & Evaluate
         */
        $buttons = resolver($buttons, compact('builder'));

        $buttons = $buttons ?: $builder->getButtons();

        $buttons = evaluate($buttons, compact('builder'));

        $buttons = Normalizer::start($buttons, 'button', 'text');

        $buttons = Normalizer::attributes($buttons);

        $builder->setButtons($buttons);

        // -----------------------------
        $this->lookup->merge($builder);
        $this->guesser->guess($builder);
        // -----------------------------

        $buttons = $builder->getButtons();

        $buttons = parse($buttons);
        $buttons = translate($buttons);

        $builder->setButtons($buttons);
    }
}

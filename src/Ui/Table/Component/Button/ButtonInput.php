<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableNormalizer;

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
     * The dropdown utility.
     *
     * @var ButtonDropdown
     */
    protected $dropdown;

    /**
     * Create a new ButtonInput instance.
     *
     * @param ButtonLookup     $lookup
     * @param ButtonGuesser    $guesser
     * @param ButtonDropdown   $dropdown
     */
    public function __construct(
        ButtonLookup $lookup,
        ButtonGuesser $guesser,
        ButtonDropdown $dropdown
    ) {
        $this->lookup     = $lookup;
        $this->guesser    = $guesser;
        $this->dropdown   = $dropdown;
    }

    /**
     * Read builder button input.
     *
     * @param TableBuilder $builder
     */
    public function read(TableBuilder $builder)
    {

        $buttons = $builder->getButtons();

        /**
         * Resolve & Evaluate
         */
        $buttons = resolver($buttons, compact('builder'));

        $buttons = $buttons ?: $builder->getButtons();

        $buttons = evaluate($buttons, compact('builder'));

        $builder->setButtons($buttons);

        // ---------------------------------
        $buttons = $builder->getButtons();

        $buttons = TableNormalizer::buttons($buttons);
        $buttons = TableNormalizer::attributes($buttons);
        $buttons = TableNormalizer::dropdowns($buttons);

        $builder->setButtons($buttons);
        // ---------------------------------

        $this->dropdown->flatten($builder);
        $this->lookup->merge($builder);

        TableGuesser::buttons($builder, $builder->getTableStream());

        $this->guesser->guess($builder);
        $this->dropdown->build($builder);

        $builder->setButtons(translate($builder->getButtons()));
    }
}

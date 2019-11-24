<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ActionInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ActionInput
{

    /**
     * The action lookup.
     *
     * @var ActionLookup
     */
    protected $lookup;

    /**
     * The action guesser.
     *
     * @var ActionGuesser
     */
    protected $guesser;

    /**
     * The dropdown utility.
     *
     * @var ActionDropdown
     */
    protected $dropdown;

    /**
     * The action predictor.
     *
     * @var ActionPredictor
     */
    protected $predictor;

    /**
     * Create a new ActionInput instance.
     *
     * @param ActionLookup     $lookup
     * @param ActionGuesser    $guesser
     * @param ActionDropdown   $dropdown
     * @param ActionPredictor  $predictor
     */
    public function __construct(
        ActionLookup $lookup,
        ActionGuesser $guesser,
        ActionDropdown $dropdown,
        ActionPredictor $predictor
    ) {
        $this->lookup     = $lookup;
        $this->guesser    = $guesser;
        $this->dropdown   = $dropdown;
        $this->predictor  = $predictor;
    }

    /**
     * Read builder action input.
     *
     * @param  TableBuilder $builder
     * @return array
     */
    public function read(TableBuilder $builder)
    {
        $actions = $builder->getActions();

        /**
         * Resolve & Evaluate
         */
        $actions = resolver($actions, compact('builder'));

        $actions = $actions ?: $builder->getButtons();

        $actions = evaluate($actions, compact('builder'));

        $builder->setActions($actions);

        // ------------------------------
        $this->predictor->predict($builder);
        // ------------------------------

        $actions = $builder->getActions();
        $actions = Normalizer::start($actions, 'action', 'slug', true);
        $actions = Normalizer::attributes($actions);
        $actions = Normalizer::dropdowns($actions);

        $builder->setActions($actions);

        // ------------------------------
        $this->dropdown->flatten($builder);
        $this->lookup->merge($builder);
        $this->guesser->guess($builder);
        // ------------------------------

        $actions = $builder->getActions();
        $actions = parse($actions);
        $builder->setActions($actions);

        // ------------------------------
        $this->dropdown->build($builder);
        // ------------------------------

        $actions = $builder->getActions();

        $actions = translate($actions);

        $builder->setActions(translate($builder->getActions()));
    }
}

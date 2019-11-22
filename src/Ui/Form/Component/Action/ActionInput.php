<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

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
     * The action dropdown utility.
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
     * Create an ActionInput instance.
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
     * @param FormBuilder $builder
     */
    public function read(FormBuilder $builder)
    {
        $actions = $builder->getActions();
        $entry = $builder->getFormEntry();

        /**
         * Resolve & Evaluate
         */
        $actions = resolver($actions, compact('builder', 'entry'));

        $actions = $actions ?: $builder->getButtons();

        $actions = evaluate($actions, compact('builder', 'entry'));

        /**
         * Default
         */
        if ($actions === []) {
            if ($builder->getFormMode() == 'create') {
                $actions = [
                    'save',
                    'save_create',
                ];
            } else {
                $actions = [
                    'update',
                    'save_exit',
                ];
            }
        }


        $builder->setActions($actions);

        // ---------------------------------
        $this->predictor->predict($builder);
        // ---------------------------------

        $actions = $builder->getActions();

        /**
         * Normalize
         */
        $actions = Normalizer::start($actions, 'actions');
        $actions = Normalizer::attributes($actions);

        $builder->setActions($actions);

        // ---------------------------------
        $this->guesser->guess($builder);
        $this->lookup->merge($builder);
        // ---------------------------------
        $actions = parse($actions, compact('entry'));
        // ---------------------------------
        $this->dropdown->build($builder);
        // ---------------------------------
        $actions = translate($actions);

        $builder->setActions($actions);
    }
}

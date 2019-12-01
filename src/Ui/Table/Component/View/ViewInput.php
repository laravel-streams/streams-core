<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ViewInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewInput
{

    /**
     * The view lookup.
     *
     * @var ViewLookup
     */
    protected $lookup;

    /**
     * The view guesser.
     *
     * @var ViewGuesser
     */
    protected $guesser;

    /**
     * The view defaults.
     *
     * @var ViewDefaults
     */
    protected $defaults;

    /**
     * Create a new ViewInput instance.
     *
     * @param ViewLookup     $lookup
     * @param ViewGuesser    $guesser
     * @param ViewDefaults   $defaults
     */
    public function __construct(
        ViewLookup $lookup,
        ViewGuesser $guesser,
        ViewDefaults $defaults
    ) {
        $this->lookup     = $lookup;
        $this->guesser    = $guesser;
        $this->defaults   = $defaults;
    }

    /**
     * Read builder view input.
     *
     * @param  TableBuilder $builder
     * @return array
     */
    public function read(TableBuilder $builder)
    {
        $views = $builder->getViews();

        /**
         * Resolve & Evaluate
         */
        $views = resolver($views, compact('builder'));

        $views = $views ?: $builder->getViews();

        $views = evaluate($views, compact('builder'));

        $builder->setViews($views);

        // ---------------------------------
        $views = $builder->getViews();

        $views = TableNormalizer::views($views);
        $views = TableNormalizer::attributes($views);

        $builder->setViews($views);
        // ---------------------------------

        $this->resolver->resolve($builder);
        $this->defaults->defaults($builder);
        $this->normalizer->normalize($builder);
        $this->lookup->merge($builder);
        $this->guesser->guess($builder);

        $builder->setViews(translate($builder->getViews()));
    }
}

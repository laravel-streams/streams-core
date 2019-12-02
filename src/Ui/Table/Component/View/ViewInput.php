<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableNormalizer;

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
     * Create a new ViewInput instance.
     *
     * @param ViewLookup     $lookup
     * @param ViewGuesser    $guesser
     */
    public function __construct(ViewLookup $lookup)
    {
        $this->lookup     = $lookup;
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

        /**
         * Defaults
         */
        if (
            ($stream = $builder->getTableStream())
            && $stream->isTrashable()
            && !$builder->getViews()
            && !$builder->isAjax()
        ) {
            $builder->setViews(
                [
                    'all',
                    'trash',
                ]
            );
        }

        /**
         * Normalize
         */
        $views = TableNormalizer::views($views);
        $views = TableNormalizer::attributes($views);

        $builder->setViews($views);
        // ---------------------------------

        $this->lookup->merge($builder);

        TableGuesser::views($builder);

        $builder->setViews(translate($builder->getViews()));
    }
}

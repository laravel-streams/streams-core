<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableNormalizer;

/**
 * Class HeaderInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HeaderInput
{

    /**
     * @var HeaderGuesser
     */
    protected $guesser;

    /**
     * The header defaults;
     *
     * @var HeaderDefaults
     */
    protected $defaults;

    /**
     * Create a new HeaderInput instance.
     *
     * @param HeaderGuesser    $guesser
     * @param HeaderDefaults   $defaults
     */
    public function __construct(
        HeaderGuesser $guesser,
        HeaderDefaults $defaults
    ) {
        $this->guesser    = $guesser;
        $this->defaults   = $defaults;
    }

    /**
     * Read builder header input.
     *
     * @param  TableBuilder $builder
     * @return array
     */
    public function read(TableBuilder $builder)
    {
        $columns = $builder->getFilters();
        $stream = $builder->getTableStream();

        /**
         * Resolve & Evaluate
         */
        $columns = resolver($columns, compact('builder'));

        $columns = $columns ?: $builder->getFilters();

        $columns = evaluate($columns, compact('builder'));

        $builder->setColumns($columns);

        // ---------------------------------
        $columns = $builder->getFilters();

        $columns = TableNormalizer::headers($columns);
        $columns = TableNormalizer::attributes($columns);

        $builder->setColumns($columns);
        // ---------------------------------


        $this->defaults->defaults($builder);
        $this->guesser->guess($builder);

        $builder->setColumns(translate($builder->getColumns()));
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Guesser\PlaceholdersGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class FilterGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterGuesser
{

    /**
     * The placeholders guesser.
     *
     * @var PlaceholdersGuesser
     */
    protected $placeholders;

    /**
     * Create a new FilterGuesser instance.
     *
     * @param PlaceholdersGuesser $placeholders
     */
    public function __construct(PlaceholdersGuesser $placeholders)
    {
        $this->placeholders = $placeholders;
    }

    /**
     * Guess some table filter properties.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $this->placeholders->guess($builder);
    }
}

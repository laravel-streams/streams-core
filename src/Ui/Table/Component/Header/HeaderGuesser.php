<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Ui\Table\Component\Header\Guesser\HeadingsGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header
 */
class HeaderGuesser
{

    /**
     * The field guesser.
     *
     * @var HeadingsGuesser
     */
    protected $heading;

    /**
     * Create a new HeaderGuesser instance.
     *
     * @param HeadingsGuesser $headings
     */
    public function __construct(HeadingsGuesser $headings)
    {
        $this->headings = $headings;
    }

    /**
     * Guess header properties.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $this->headings->guess($builder);
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ViewGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ViewGuesser
{

    /**
     * The HREF guesser.
     *
     * @var HrefGuesser
     */
    protected $href;

    /**
     * Create a new ViewGuesser instance.
     *
     * @param HrefGuesser $href
     */
    public function __construct(HrefGuesser $href)
    {
        $this->href = $href;
    }

    /**
     * Guess some view parameters.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $this->href->guess($builder);
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser\HandlerGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser\QueryGuesser;
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
     * The query guesser.
     *
     * @var QueryGuesser
     */
    protected $query;

    /**
     * The query guesser.
     *
     * @var HandlerGuesser
     */
    protected $handler;

    /**
     * Create a new ViewGuesser instance.
     *
     * @param HrefGuesser    $href
     * @param QueryGuesser   $query
     * @param HandlerGuesser $handler
     */
    public function __construct(HrefGuesser $href, QueryGuesser $query, HandlerGuesser $handler)
    {
        $this->href    = $href;
        $this->query   = $query;
        $this->handler = $handler;
    }

    /**
     * Guess some view parameters.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $this->href->guess($builder);
        $this->query->guess($builder);
        $this->handler->guess($builder);
    }
}

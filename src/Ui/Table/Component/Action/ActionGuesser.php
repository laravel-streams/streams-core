<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Guesser\HandlerGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ActionGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionGuesser
{

    /**
     * The text guesser.
     *
     * @var TextGuesser
     */
    protected $text;

    /**
     * The handler guesser.
     *
     * @var HandlerGuesser
     */
    protected $handler;

    /**
     * Create a new ActionGuesser instance.
     *
     * @param TextGuesser    $text
     * @param HandlerGuesser $handler
     */
    public function __construct(TextGuesser $text, HandlerGuesser $handler)
    {
        $this->text    = $text;
        $this->handler = $handler;
    }

    /**
     * Guess action parameters.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $this->text->guess($builder);
        $this->handler->guess($builder);
    }
}

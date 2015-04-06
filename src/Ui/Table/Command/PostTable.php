<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Event\TableIsPosting;
use Anomaly\Streams\Platform\Ui\Table\Event\TableWasPosted;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Events\Dispatcher;

/**
 * Class PostTable
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class PostTable implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new PostTable instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Dispatcher $events
     */
    public function handle(Dispatcher $events)
    {
        $this->builder->fire('posting');
        $events->fire(new TableIsPosting($this->builder));

        $this->builder->fire('posted');
        $events->fire(new TableWasPosted($this->builder));
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Routing\ResponseFactory;

/**
 * Class SetTableResponse
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetTableResponse implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new SetTableResponse instance.
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
     * @param ResponseFactory $response
     */
    public function handle(ResponseFactory $response)
    {
        $table = $this->builder->getTable();

        $options = $table->getOptions();
        $data    = $table->getData();

        $table->setResponse($response->view($options->get('wrapper_view', 'streams::blank'), $data));
    }
}

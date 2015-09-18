<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\ExecuteAction;
use Anomaly\Streams\Platform\Ui\Table\Multiple\MultipleTableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

/**
 * Class PostTable.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class PostTable implements SelfHandling
{
    use DispatchesJobs;

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
     * @param Request         $request
     * @param ResponseFactory $response
     * @throws \Exception
     */
    public function handle(Request $request, ResponseFactory $response)
    {
        if ($this->builder instanceof MultipleTableBuilder) {
            return;
        }

        $this->dispatch(new ExecuteAction($this->builder));

        if (! $this->builder->getTableResponse()) {
            $this->builder->setTableResponse($response->redirectTo($request->fullUrl()));
        }
    }
}

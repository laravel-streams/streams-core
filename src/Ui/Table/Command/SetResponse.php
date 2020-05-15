<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Request;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SetResponse
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetResponse
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
        if (Request::has('_async')) {

            $this->builder->table->response = $response->make($this->builder->table->toJson());

            return;
        }

        $this->builder->table->response = $response->view(
            $this->builder->table->options->get('wrapper_view', 'streams::default'),
            [
                'content' => $this->builder->table->render(),
            ]
        );
    }
}

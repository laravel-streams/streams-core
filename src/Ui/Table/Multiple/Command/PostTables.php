<?php

namespace Anomaly\Streams\Platform\Ui\Table\Multiple\Command;

use Anomaly\Streams\Platform\Ui\Table\Multiple\MultipleTableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

/**
 * Class PostTables
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PostTables
{

    /**
     * The multiple form builder.
     *
     * @var MultipleTableBuilder
     */
    protected $builder;

    /**
     * Create a new PostTables instance.
     *
     * @param MultipleTableBuilder $builder
     */
    public function __construct(MultipleTableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param ResponseFactory $response
     * @param Request         $request
     */
    public function handle(ResponseFactory $response, Request $request)
    {
        /* @var TableBuilder $builder */
        foreach ($this->builder->tables as $builder) {
            $builder->post();
        }

        if (!$this->builder->table->response) {
            $this->builder->table->response = $response->redirectTo($request->fullUrl());
        }
    }
}

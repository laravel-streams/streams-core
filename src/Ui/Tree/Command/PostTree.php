<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Command;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class PostTree.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Command
 */
class PostTree implements SelfHandling
{
    use DispatchesJobs;

    /**
     * The tree builder.
     *
     * @var TreeBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTree instance.
     *
     * @param TreeBuilder $builder
     */
    public function __construct(TreeBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->dispatch(new SaveTree($this->builder));
    }
}

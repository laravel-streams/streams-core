<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Row\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Row\RowBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class BuildRows
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Row\Command
 */
class BuildRows implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildRows instance.
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
     * @param RowBuilder $builder
     */
    public function handle(RowBuilder $builder)
    {
        $builder->build($this->builder);
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldBuilder;

/**
 * Class BuildFieldsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Listener\Command
 */
class BuildFieldsCommandHandler
{

    /**
     * The field builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFieldsCommandHandler instance.
     *
     * @param FieldBuilder $builder
     */
    public function __construct(FieldBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build fields and load them to the table.
     *
     * @param BuildFieldsCommand $command
     */
    public function handle(BuildFieldsCommand $command)
    {
        $this->builder->build($command->getBuilder());
    }
}

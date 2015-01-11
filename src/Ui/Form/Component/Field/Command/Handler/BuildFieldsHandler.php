<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Component\Field\Command\BuildFields;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldBuilder;

/**
 * Class BuildFieldsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Listener\Command
 */
class BuildFieldsHandler
{

    /**
     * The field builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFieldsHandler instance.
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
     * @param BuildFields $command
     */
    public function handle(BuildFields $command)
    {
        $this->builder->build($command->getBuilder());
    }
}

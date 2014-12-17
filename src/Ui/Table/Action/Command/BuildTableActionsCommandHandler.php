<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Action\ActionConverter;

/**
 * Class BuildTableActionsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Command
 */
class BuildTableActionsCommandHandler
{

    /**
     * The action converter.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Action\ActionConverter
     */
    protected $converter;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param ActionConverter $converter
     */
    public function __construct(ActionConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Load the action objects to the table.
     *
     * @param BuildTableActionsCommand $command
     */
    public function handle(BuildTableActionsCommand $command)
    {
        $this->converter->build($command->getBuilder());
    }
}

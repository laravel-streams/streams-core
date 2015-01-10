<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderHeading;

/**
 * Class GetHeadingCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header\Command
 */
class GetHeadingCommandHandler
{

    /**
     * The header utility.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderHeading
     */
    protected $header;

    /**
     * Create a new GetHeadingCommandHandler instance.
     *
     * @param HeaderHeading $header
     */
    public function __construct(HeaderHeading $header)
    {
        $this->header = $header;
    }

    /**
     * Handle the command.
     *
     * @param GetHeadingCommand $command
     * @return null|string
     */
    public function handle(GetHeadingCommand $command)
    {
        $table  = $command->getTable();
        $header = $command->getHeader();

        return $this->header->make($table, $header);
    }
}

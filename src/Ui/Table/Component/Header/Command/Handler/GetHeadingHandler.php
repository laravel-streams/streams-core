<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Header\Command\GetHeading;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderHeading;

/**
 * Class GetHeadingHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header\Command
 */
class GetHeadingHandler
{

    /**
     * The header utility.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderHeading
     */
    protected $header;

    /**
     * Create a new GetHeadingHandler instance.
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
     * @param GetHeading $command
     * @return null|string
     */
    public function handle(GetHeading $command)
    {
        $table  = $command->getTable();
        $header = $command->getHeader();

        return $this->header->make($table, $header);
    }
}

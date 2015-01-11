<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Header\Contract\HeaderInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class GetHeading
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class GetHeading
{

    /**
     * The table object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Table
     */
    protected $table;

    /**
     * The header object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Header\Contract\HeaderInterface
     */
    protected $header;

    /**
     * Create a new GetHeading instance.
     *
     * @param Table           $table
     * @param HeaderInterface $header
     */
    function __construct(Table $table, HeaderInterface $header)
    {
        $this->table  = $table;
        $this->header = $header;
    }

    /**
     * Get the header object.
     *
     * @return HeaderInterface
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Get the table object.
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }
}

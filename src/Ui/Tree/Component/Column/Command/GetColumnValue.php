<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Column\Command;

use Anomaly\Streams\Platform\Ui\Tree\Component\Column\Contract\ColumnInterface;
use Anomaly\Streams\Platform\Ui\Tree\Tree;

/**
 * Class GetColumnValue
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Command
 */
class GetColumnValue
{

    /**
     * The tree object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Tree\Tree
     */
    protected $tree;

    /**
     * The column object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Tree\Component\Column\Contract\ColumnInterface
     */
    protected $column;

    /**
     * The entry object.
     *
     * @var mixed
     */
    protected $entry;

    /**
     * Create a new GetColumnValue instance.
     *
     * @param Tree           $tree
     * @param ColumnInterface $column
     * @param                 $entry
     */
    function __construct(Tree $tree, ColumnInterface $column, $entry)
    {
        $this->entry  = $entry;
        $this->tree  = $tree;
        $this->column = $column;
    }

    /**
     * Get the column object.
     *
     * @return ColumnInterface
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Get the tree object.
     *
     * @return Tree
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * Get the entry object.
     *
     * @return mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }
}

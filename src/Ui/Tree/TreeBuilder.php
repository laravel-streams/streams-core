<?php namespace Anomaly\Streams\Platform\Ui\Tree;

/**
 * Class TreeBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree
 */
class TreeBuilder
{

    /**
     * The tree instance.
     *
     * @var Tree
     */
    protected $tree;

    /**
     * @param Tree $tree
     */
    function __construct(Tree $tree)
    {
        $this->tree = $tree;
    }

    /**
     * Get the tree.
     *
     * @return Tree
     */
    public function getTree()
    {
        return $this->tree;
    }
}

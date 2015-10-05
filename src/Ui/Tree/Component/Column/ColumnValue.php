<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Column;

use Anomaly\Streams\Platform\Support\Value;
use Anomaly\Streams\Platform\Ui\Tree\Tree;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\View\View;

/**
 * Class ColumnValue
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Column
 */
class ColumnValue
{

    /**
     * The value resolver.
     *
     * @var Value
     */
    protected $value;

    /**
     * Create a new ColumnValue instance.
     *
     * @param Value $value
     */
    public function __construct(Value $value)
    {
        $this->value = $value;
    }

    /**
     * Return the column value.
     *
     * @param Tree $tree
     * @param array $column
     * @param       $entry
     * @return View|mixed|null
     */
    public function make(Tree $tree, array $column, $entry)
    {
        return $this->value->make($column, $entry, 'entry', compact('tree'));
    }
}

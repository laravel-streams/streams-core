<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Support\Value;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\View\View;

/**
 * Class ColumnValue
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column
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
     * @param Table $table
     * @param array $column
     * @param       $entry
     * @return View|mixed|null
     */
    public function make(Table $table, $column, $entry)
    {
        if (is_array($column['value'])) {
            foreach ($column['value'] as &$value) {
                $value = $this->value->make($value, $entry, 'entry', compact('table'));
            }
        }

        return $this->value->make($column, $entry, 'entry', compact('table'));
    }
}

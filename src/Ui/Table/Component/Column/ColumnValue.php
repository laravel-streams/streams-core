<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Contract\ColumnInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

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
     * The evaluator utility.
     *
     * @var \Anomaly\Streams\Platform\Support\Evaluator
     */
    protected $evaluator;

    /**
     * Create a new ColumnValue instance.
     *
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Return the column value.
     *
     * @param Table           $table
     * @param ColumnInterface $column
     * @param                 $entry
     * @return \Illuminate\View\View|mixed|null
     */
    public function make(Table $table, ColumnInterface $column, $entry)
    {
        $value = $column->getValue();

        /**
         * If the entry is an instance of EntryInterface
         * then try getting the field value from the entry.
         */
        if ($entry instanceof EntryInterface && $entry->getField($value)) {
            return $entry->getFieldValue($value);
        }

        /**
         * If the value is a view path then return a view.
         */
        if (str_is('*.*.*::*', $value)) {
            return view($value, compact('table', 'entry'));
        }

        /**
         * Decorate the entry object before
         * sending to decorate so that data_get()
         * can get into the presenter methods.
         */
        $entry = $entry->getPresenter();

        /**
         * By default we can just pass the value through
         * the evaluator utility and be done with it.
         */
        $value = $this->evaluator->evaluate($value, compact('table', 'entry'));

        return $value;
    }
}

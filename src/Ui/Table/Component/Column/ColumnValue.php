<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Contract\ColumnInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Robbo\Presenter\PresentableInterface;
use StringTemplate\Engine;

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
     * The string parser.
     *
     * @var Engine
     */
    protected $parser;

    /**
     * The evaluator utility.
     *
     * @var \Anomaly\Streams\Platform\Support\Evaluator
     */
    protected $evaluator;

    /**
     * Create a new ColumnValue instance.
     *
     * @param Engine    $parser
     * @param Evaluator $evaluator
     */
    public function __construct(Engine $parser, Evaluator $evaluator)
    {
        $this->parser    = $parser;
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
        if ($view = $column->getView()) {
            return view($view, compact('table', 'entry', 'value'));
        }

        /**
         * If the value matches a field with a relation
         * then parse the string using the eager loaded entry.
         */
        if (preg_match("/^entry.([a-zA-Z\\_]+)./", $value, $match)) {

            $fieldSlug = camel_case($match[1]);

            if (method_exists($entry, $fieldSlug) && ($relation = $entry->{$fieldSlug}()) instanceof Relation) {
                return data_get(
                    compact('entry'),
                    str_replace(".{$match[1]}.", '.' . camel_case($match[1]) . '.', $value)
                );
            }
        }

        /**
         * Decorate the entry object before
         * sending to decorate so that data_get()
         * can get into the presenter methods.
         */
        if ($entry instanceof PresentableInterface) {
            $entry = $entry->getPresenter();
        }

        /**
         * By default we can just pass the value through
         * the evaluator utility and be done with it.
         */
        $value = $this->evaluator->evaluate($value, compact('table', 'entry'));

        /**
         * Lastly, prepare the entry to be
         * parsed into the string.
         */
        if ($entry instanceof Arrayable) {
            $entry = $entry->toArray();
        } else {
            $entry = null;
        }

        return $this->parser->render($column->getWrap(), compact('value', 'entry'));
    }
}

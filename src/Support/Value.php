<?php namespace Anomaly\Streams\Platform\Support;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\Relation;
use StringTemplate\Engine;

/**
 * Class Value
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Value
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
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * The decorator utility.
     *
     * @var Decorator
     */
    protected $decorator;

    /**
     * Create a new ColumnValue instance.
     *
     * @param Engine    $parser
     * @param Evaluator $evaluator
     * @param Decorator $decorator
     */
    public function __construct(Engine $parser, Evaluator $evaluator, Decorator $decorator)
    {
        $this->parser    = $parser;
        $this->evaluator = $evaluator;
        $this->decorator = $decorator;
    }

    /**
     * Make a value from the parameters and entry.
     *
     * @param $parameters
     * @param $payload
     * @return mixed|string
     */
    public function make($parameters, $entry, $term = 'entry')
    {
        if (is_string($parameters)) {
            $parameters = [
                'wrapper' => '{value}',
                'value'   => $parameters
            ];
        }

        $value = array_get($parameters, 'value');

        /**
         * If the value is a view path then return a view.
         */
        if ($view = array_get($parameters, 'view')) {
            return view($view, compact('table', $term, 'value'));
        }

        /**
         * If the entry is an instance of EntryInterface
         * then try getting the field value from the entry.
         */
        if ($entry instanceof EntryInterface && $entry->getField($value)) {

            /* @var EntryInterface $relation */
            if ($entry->assignmentIsRelationship($value) && $relation = $entry->{camel_case($value)}) {
                $value = $relation->getTitle();
            } else {
                $value = $entry->getFieldValue($value);
            }
        }

        /**
         * If the value matches a field with a relation
         * then parse the string using the eager loaded entry.
         */
        if (is_string($value) && preg_match("/^{$term}.([a-zA-Z\\_]+)/", $value, $match)) {

            $fieldSlug = camel_case($match[1]);

            if (method_exists($entry, $fieldSlug) && $entry->{$fieldSlug}() instanceof Relation) {

                $entry = $this->decorator->decorate($entry);

                $value = data_get(
                    compact('entry'),
                    str_replace("{$term}.{$match[1]}.", 'entry.' . camel_case($match[1]) . '.', $value)
                );
            }
        }

        /**
         * Decorate the entry object before
         * sending to decorate so that data_get()
         * can get into the presenter methods.
         */
        $entry = $this->decorator->decorate($entry);

        /**
         * If the value matches a method in the presenter.
         */
        if (is_string($value) && preg_match("/^{$term}.([a-zA-Z\\_]+)/", $value, $match)) {
            if (method_exists($entry, camel_case($match[1]))) {
                $value = $entry->{camel_case($match[1])}();
            }
        }

        /**
         * By default we can just pass the value through
         * the evaluator utility and be done with it.
         */
        $value = $this->evaluator->evaluate($value, compact($term));

        /**
         * Lastly, prepare the entry to be
         * parsed into the string.
         */
        if ($entry instanceof Arrayable) {
            $entry = $entry->toArray();
        } else {
            $entry = null;
        }

        /**
         * Parse the value with the entry.
         */
        $value = $this->parser->render($parameters['wrapper'], compact('value', $term));

        /**
         * If the value looks like a language
         * key then try translating it.
         */
        if (str_is('*.*.*::*', $value)) {
            $value = trans($value);
        }

        return $value;
    }
}

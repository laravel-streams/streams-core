<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Contract\ArrayableInterface;

/**
 * Class Evaluator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class Evaluator
{

    /**
     * An array of evaluating closures to run.
     *
     * @var array
     */
    protected $evaluators = [];

    /**
     * Evaluate closures in the entire data array.
     * Merge in entry data at this point as well if available.
     *
     * @param array $data
     * @param array $arguments
     * @param null  $entry
     * @return array|mixed|null
     */
    public function evaluate(array $data, array $arguments = [], $entry = null)
    {
        $data = evaluate($data, $arguments);

        /**
         * In addition to evaluating we need
         * to merge in entry data as best we can.
         */
        foreach ($data as &$value) {

            if (is_string($value) and str_contains($value, '{{')) {

                $value = $this->parseValue($value, $entry);
            }
        }

        if ($this->evaluators) {

            $this->runEvaluators($data);
        }

        return $data;
    }

    /**
     * Parse the entry data into a string.
     *
     * @param $value
     * @param $entry
     * @return mixed
     */
    protected function parseValue($value, $entry)
    {
        if ($entry instanceof ArrayableInterface) {

            return view()->parse($value, $entry->toArray());
        }

        if (is_array($entry)) {

            return view()->parse($value, $entry);
        }

        return $value;
    }

    /**
     * Add an evaluator.
     *
     * @param callable $callback
     * @return $this
     */
    public function addEvaluator(\Closure $callback)
    {
        $this->evaluators[] = $callback;

        return $this;
    }

    /**
     * Run the evaluators.
     *
     * @param array $data
     */
    protected function runEvaluators(array &$data)
    {
        foreach ($data as &$value) {

            foreach ($this->evaluators as $evaluator) {

                $value = $evaluator($value);
            }
        }
    }
}
 
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
     * @param null  $parseData
     * @return array|mixed|null
     */
    public function evaluate(array $data, array $arguments = [], $parseData = null)
    {
        $data = evaluate($data, $arguments);

        /**
         * In addition to evaluating we need
         * to merge in entry data as best we can.
         */
        foreach ($data as &$value) {

            if (is_string($value) and str_contains($value, '{{')) {

                $value = $this->parseValue($value, $parseData);
            }
        }

        if ($this->evaluators) {

            $data = $this->runEvaluators($data);
        }

        return $data;
    }

    /**
     * Parse the entry data into a string.
     *
     * @param $value
     * @param $data
     * @return mixed
     */
    protected function parseValue($value, $data)
    {
        if ($data instanceof ArrayableInterface) {

            return view()->parse($value, $data->toArray());
        }

        if (is_array($data)) {

            return view()->parse($value, $data);
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
     * @return array
     */
    protected function runEvaluators(array $data)
    {
        $evaluated = [];

        foreach ($data as $key => $value) {

            foreach ($this->evaluators as $evaluator) {

                $evaluated[$key] = $evaluator($value);
            }
        }

        return $evaluated;
    }
}
 
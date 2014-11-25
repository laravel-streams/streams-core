<?php namespace Anomaly\Streams\Platform\Ui;

/**
 * Class Expander
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class Expander
{

    /**
     * Available expanders to run.
     *
     * @var array
     */
    protected $expanders = [];

    /**
     * Expand minimal input into something helpful.
     *
     * @param $slug
     * @param $data
     * @return array
     */
    public function expand($slug, $data, $dataKey = null)
    {
        /**
         * If the format is like ['slug'] then return
         * the data as the slug.
         */
        if (is_numeric($slug) and is_string($data)) {

            return [
                'slug' => $data,
            ];
        }

        /**
         * If the format is like ['slug' => $data] and
         * data is a string then use the data key to
         * set the data and the slug as itself.
         */
        if (!is_numeric($slug) and !is_array($data) and $dataKey) {

            return [
                'slug'   => $slug,
                $dataKey => $data
            ];
        }

        /**
         * If the format is like ['slug' => $data] and
         * data is an array then set the slug and return it.
         */
        if (!is_numeric($slug) and is_array($data) and !isset($data['slug'])) {

            $data['slug'] = $slug;

            return $data;
        }

        /**
         * Even though it is garbage, set a slug for later.
         */
        if (is_array($data) and !isset($data['slug'])) {

            $data['slug'] = $slug;
        }

        /**
         * Run additional expanders if any.
         */
        if ($this->expanders) {

            $data = $this->runExpanders($data);
        }

        return (array)$data;
    }

    /**
     * Add an expander.
     *
     * @param callable $callback
     * @return $this
     */
    public function addExpander(\Closure $callback)
    {
        $this->expanders[] = $callback;

        return $this;
    }

    /**
     * Run the expanders.
     *
     * @param array $data
     * @return array
     */
    protected function runExpanders(array $data)
    {
        $expanded = [];

        foreach ($data as $key => $value) {

            foreach ($this->expanders as $expander) {

                $expanded[$key] = $expander($value);
            }
        }

        return $expanded;
    }
}
 
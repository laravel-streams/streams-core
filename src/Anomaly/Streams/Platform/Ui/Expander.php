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

        return $data;
    }
}
 